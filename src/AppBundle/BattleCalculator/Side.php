<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 11:00
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\AirUnit;
use Symfony\Bridge\Monolog\Logger;

use AppBundle\BattleCalculator\Unit\Unit;

abstract class Side
{

    const ATTACKER = 'attacker';
    const DEFENDER = 'defender';

    /**
     * @var Unit[]
     */
    protected $units = [];

    /**
     * @var Unit[]
     */
    protected $lostUnits = [];

    /**
     * @var Unit[]
     */
    protected $casualties = [];

    /**
     * @var Unit[]
     */
    protected $removed = [];

    /**
     * @var array
     */
    protected $unitsByType = [];

    /**
     * @var array
     */
    protected $unitsByTag = [];

    /**
     * @var array
     */
    protected $blockedUnits = [];

    /**
     * @var Battle
     */
    protected $battle;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param $units
     * @param Logger $logger
     */
    abstract function __construct($units, Battle $battle, Logger $logger = null);

    /**
     * @return Unit[]
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @return Unit[]
     */
    public function getLostUnits()
    {
        return $this->lostUnits;
    }

    /**
     * @return Unit[]
     */
    public function getCasualties()
    {
        return $this->casualties;
    }

    /**
     * @param Unit $unit
     */
    public function addUnit(Unit $unit) {
        if($this->logger)
            $this->logger->info('adding unit', [$unit->getName(), spl_object_hash($unit)]);

        $this->units[] = $unit;
    }

    /**
     * @param Unit $unit
     */
    public function removeUnit(Unit $unit) {
        if(in_array($unit, $this->units, true)) {
            if($this->logger)
                $this->logger->info('removing unit', [$unit->getName(), spl_object_hash($unit)]);

            unset($this->units[array_search($unit, $this->units, true)]);
        }
    }

    /**
     * @param Unit $casualty
     */
    public function addCasualty(Unit $casualty)
    {
     /*   if($this->logger)
            $this->logger->info('adding casualty', [$casualty->getName(), spl_object_hash($casualty)]);*/

        $this->casualties[] = $casualty;
    }

    /**
     * @param Unit $casualty
     */
    public function removeCasualty(Unit $casualty)
    {
        if(in_array($casualty, $this->casualties, true)) {
      /*      if($this->logger)
                $this->logger->info('removing casualty', [$casualty->getName(), spl_object_hash($casualty)]);*/

            unset($this->casualties[array_search($casualty, $this->casualties, true)]);
        }
    }

    /**
     * @param Unit $lostUnit
     */
    public function addLostUnit(Unit $lostUnit) {
      /*  if($this->logger)
            $this->logger->info('adding lost unit', [$lostUnit->getName(), spl_object_hash($lostUnit)]);*/

        $this->lostUnits[] = $lostUnit;
    }

    /**
     * @param Unit $lostUnit
     */
    public function removeLostUnit(Unit $lostUnit) {
        if(in_array($lostUnit, $this->lostUnits, true)) {
        /*    if($this->logger)
                $this->logger->info('removing lost unit', [$lostUnit->getName(), spl_object_hash($lostUnit)]);*/

            unset($this->lostUnits[array_search($lostUnit, $this->lostUnits, true)]);
        }
    }

    /**
     * @param Unit $hitBy
     * @param array $allowedClasses
     * @return Unit|null
     */
    public function applyHit(Unit $hitBy, $allowedClasses = [])
    {
        if($this->logger && $allowedClasses)
            $this->logger->info('Applying hit only to classes '. $allowedClasses, ['hitBy' => $hitBy->getName()]);

        if(count($this->units) > 0) {
            foreach ($this->units as $unit) {
                /* @var Unit $unit */

                /* Skip units that are already in casualties (hit earlier this round) */
                if( in_array($unit, $this->casualties, true)) {
                    continue;
                }

                /* Allowed Classes */
                if($allowedClasses && ! in_array(get_class($unit), $allowedClasses))
                    continue;

                /* Can't be Hit by Air Units */
                if(
                    $hitBy instanceof AirUnit &&
                    $unit->hasTag(Unit::CANT_BE_HIT_BY_AIR_UNITS) &&
                    ! count($hitBy->getSide()->getUnitsByTag(Unit::DENIES_CANT_BE_HIT_BY_AIR_UNITS)) > 0
                )
                    continue;

                /* Can't Hit Air Units */
                if(
                    $unit instanceof AirUnit &&
                    $hitBy->hasTag(Unit::CANT_HIT_AIR_UNITS)
                )
                    continue;

                /* Chosen Last */
                if(
                    $unit->hasTag(Unit::CHOSEN_LAST) &&
                    count($unit->getSide()->getUnitsByTag(Unit::CHOSEN_LAST)) < count($unit->getSide()->getUnits())
                )
                    continue;

                $unit->applyHit();

                if($unit->isDead()) {
                    $this->addCasualty($unit);
                } else {
                    $this->orderUnits();
                }

                return $unit;
            }
        }

        return null;
    }

    /**
     *
     */
    abstract function removeCasualties();

    /**
     *
     */
    protected function createUnitsByTypeAndTag()
    {
        $this->unitsByTag = [];
        $this->unitsByType = [];
        foreach($this->units as $unit){
            /** @var Unit $unit */
            foreach($unit->getTags() as $tag) {
                if(! isset($this->unitsByTag[$tag]))
                    $this->unitsByTag[$tag] = [];
                $this->unitsByTag[$tag][] = $unit;
            }
            if(! isset($this->unitsByType[get_class($unit)]))
                $this->unitsByType[get_class($unit)] = [];
            $this->unitsByType[get_class($unit)][] = $unit;
        }
    }

    /**
     *
     */
    abstract function orderUnits();


    /**
     * @param $class
     * @return array
     */
    public function getUnitsByType($class)
    {
        return
            isset($this->unitsByType[$class])?
                $this->unitsByType[$class]
                : null;
    }

    /**
     * @param $tag
     * @return array
     */
    public function getUnitsByTag($tag)
    {
        return
            isset($this->unitsByTag[$tag])?
                $this->unitsByTag[$tag]
                : null;
    }

    /**
     * Returns true if any unit of this side has the given tag.
     *
     * @param $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        foreach($this->units as $unit)
            if($unit->hasTag($tag))
                return true;
        return false;
    }

}
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

class Side
{

    const ATTACKER = 'attacker';
    const DEFENDER = 'defender';

    /**
     * @var string
     */
    protected $type;

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
     * @var Logger
     */
    protected $logger;

    function __construct($type, $units, Logger $logger = null)
    {
        if($type !== self::ATTACKER && $type !== self::DEFENDER)
            throw new \InvalidArgumentException();

        $this->logger = $logger;
        $this->type = $type;
        $this->units = $units;
        foreach($this->units as $unit)
            $unit->setSide($this);

        if($this->type === self::ATTACKER)
            $this->combineArms();

        $this->orderUnits();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

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

                /* Hit only allowed classes (i.e. Antiaircraft Artillery may only hit Air Units */
                if($allowedClasses && ! in_array(get_class($unit), $allowedClasses))
                    continue;

                /* Skip if an air unit tries to hit a unit that can't be hit by air units unless countered (i.e. Subs) */
                if(
                    $hitBy instanceof AirUnit &&
                    $unit->hasTag(Unit::CANT_BE_HIT_BY_AIR_UNITS) &&
                    ! count($hitBy->getSide()->getUnitsByTag(Unit::DENIES_CANT_BE_HIT_BY_AIR_UNITS)) > 0
                )
                    continue;

                /* Skip if a unit that can't hit air units tries to hit an air unit */
                if(
                    $unit instanceof AirUnit &&
                    $hitBy->hasTag(Unit::CANT_HIT_AIR_UNITS)
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
    public function removeCasualties()
    {
        if($this->logger)
            $this->logger->info('cleaning up casualties', ['type' => $this->getType(), 'casualties' => count($this->casualties)]);

        if(count($this->casualties) > 0) {
            foreach($this->casualties as $casualty) {
                $this->removeUnit($casualty);
                $this->addLostUnit($casualty);
                $this->removeCasualty($casualty);
                if($casualty->getCombinedWith()) {
                    $casualty->getCombinedWith()->setCombinedWith(null);
                    $casualty->getCombinedWith(null);
                }
            }
        }

        $this->orderUnits();
    }

    /**
     *
     */
    private function combineArms()
    {
        if($this->logger)
            $this->logger->info('combining arms', [$this->getType()]);

        foreach($this->units as $unit) {
            if( ! $unit->getCombinations() > 0)
                continue;
            if($unit->getCombinedWith())
                continue;

            /** @var Unit[] $combinableUnits */
            $combinableUnits = array_filter($this->units, function(Unit $u) use ($unit) {
                return isset($unit->getCombinations()[get_class($u)]) && ! $u->getCombinedWith();
            });

            if(count($combinableUnits) > 0) {
                /** @var Unit $combinableUnit */
                $combinableUnit = array_values($combinableUnits)[0];
                if($this->logger)
                    $this->logger->info('Combining ' . $unit->getName() . ' & ' .$combinableUnit->getName());
                $unit->setCombinedWith($combinableUnit);
                $combinableUnit->setCombinedWith($unit);
            }
        }
    }

    /**
     *
     */
    private function orderUnits() {
        if($this->type === self::ATTACKER) {
            $this->combineArms();
            $this->orderUnitsByAttack();
        }
        if($this->type === self::DEFENDER)
            $this->orderUnitsByDefense();

        if($this->logger)
            $this->logger->info('ordering units', [$this->getType(), array_map(function(Unit $unit) {
                return $unit->getName() . ' (' .
                    ($this->type === self::ATTACKER
                        ? $unit->getAttack()
                        : $unit->getDefense()
                    ). ')';
            }, $this->units)]);
    }

    /**
     * @return mixed
     */
    private function orderUnitsByAttack() {
        usort( $this->units, function(Unit $a, Unit $b) {
            if($a->hasTag('chosen_last') === $b->hasTag('chosen_last')) {
                if ($a->getHitPoints() === $b->getHitPoints()) {
                    if ($a->getAttack() === $b->getAttack()) {
                        return $a->getCost() - $b->getCost();
                    }
                    return $a->getAttack() - $b->getAttack();
                }
                return $a->getHitPoints() - $b->getHitPoints();
            }
            return $a->hasTag('chosen_last')? +1 : -1;
        });
    }

    /**
     * @return mixed
     */
    private function orderUnitsByDefense() {
        usort( $this->units, function(Unit $a, Unit $b) {
            if($a->hasTag('chosen_last') === $b->hasTag('chosen_last')) {
                if ($a->getHitPoints() === $b->getHitPoints()) {
                    if ($a->getDefense() === $b->getDefense()) {
                        return $a->getCost() - $b->getCost();
                    }
                    return $a->getDefense() - $b->getDefense();
                }
                return $a->getHitPoints() - $b->getHitPoints();
            }
            return $a->hasTag('chosen_last')? +1 : -1;
        });
    }

    /**
     * @param $class
     * @return array
     */
    public function getUnitsByClass($class)
    {
        return array_filter($this->units,
            function(Unit $unit) use ($class) {
                return $unit instanceof $class;
            }
        );
    }

    /**
     * @param $tag
     * @return array
     */
    public function getUnitsByTag($tag)
    {
        return array_filter($this->units,
            function(Unit $unit) use ($tag) {
                return $unit->hasTag($tag);
            }
        );
    }

}
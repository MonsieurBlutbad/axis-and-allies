<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 11:00
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\AirUnit;
use AppBundle\BattleCalculator\Unit\Destroyer;
use AppBundle\BattleCalculator\Unit\LandUnit;
use AppBundle\BattleCalculator\Unit\SeaUnit;
use AppBundle\BattleCalculator\Unit\Submarine;
use Symfony\Bridge\Monolog\Logger;

use AppBundle\BattleCalculator\Unit\Unit;

class Attacker extends Side
{

    /**
     * @param Unit[] $units
     * @param Battle $battle
     * @param Logger $logger
     */
    function __construct($units, Battle $battle, Logger $logger = null)
    {
        $this->logger = $logger;
        $this->battle = $battle;
        $this->units = $units;
        foreach($this->units as $unit)
            $unit->setSide($this);

        $this->combineArms();

        $this->createUnitsByTypeAndTag();
    }

    /**
     *
     */
    public function removeCasualties()
    {
        if($this->logger)
            $this->logger->info('cleaning up attackers casualties', ['casualties' => count($this->casualties)]);

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

        $this->createUnitsByTypeAndTag();
    }

    /**
     *
     */
    private function combineArms()
    {
        if($this->logger)
            $this->logger->info('combining arms');

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
    public function orderUnits() {
        $this->combineArms();

        if($this->battle->getCalculator()->getSettings()->getMustTakeTerritory()) {
            $landUnits = $this->orderUnitsByAttack(
                $this->getUnitsByType(LandUnit::class)
            );
            $lastLandUnit = array_pop($landUnits);
            $otherUnits = $this->orderUnitsByAttack(
                array_merge( $this->getUnitsByType(SeaUnit::class)? : [], $this->getUnitsByType(AirUnit::class)? : [])
            );
            $this->units = array_merge($landUnits, $otherUnits);
            $this->units[] = $lastLandUnit;
        } else {
            $this->units = $this->orderUnitsByAttack($this->units);
        }

        if($this->battle->getCalculator()->getSettings()->getKeepDestroyers()) {
            if(count($this->battle->getDefender()->getUnitsByType(Submarine::class)) > 0) {
                foreach($this->units as $i => $unit) {
                    if($unit instanceof Destroyer) {
                        unset($this->units[$i]);
                        $this->units[] = $unit;
                        break;
                    }
                }
            }
        }

        if($this->logger)
            $this->logger->info('ordering attacker units', [array_map(function(Unit $unit) {
                return $unit->getName() . ' (' . $unit->getAttack() . ')';
            }, $this->units)]);
    }

    /**
     * @param Unit[] $units
     * @return mixed
     */
    private function orderUnitsByAttack($units)
    {
        if(count($units) > 1) {
            usort( $units, function(Unit $a, Unit $b) {
                if($a->hasTag('chosen_last') === $b->hasTag('chosen_last')) {
                    if ($a->getHitPoints() === $b->getHitPoints()) {
                        if ($a->getAttack() === $b->getAttack()) {
                            return $a->getCost() - $b->getCost();
                        }
                        return $a->getAttack() - $b->getAttack();
                    }
                    return $b->getHitPoints() - $a->getHitPoints();
                }
                return $a->hasTag('chosen_last')? +1 : -1;
            });
        }
        return $units;
    }

}
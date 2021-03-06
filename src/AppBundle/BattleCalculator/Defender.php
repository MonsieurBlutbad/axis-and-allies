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
use AppBundle\BattleCalculator\Unit\Submarine;
use Symfony\Bridge\Monolog\Logger;

use AppBundle\BattleCalculator\Unit\Unit;

class Defender extends Side
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

        $this->createUnitsByTypeAndTag();
    }

    /**
     *
     */
    public function removeCasualties()
    {
        if($this->logger)
            $this->logger->info('cleaning up defenders casualties', ['casualties' => count($this->casualties)]);

        if(count($this->casualties) > 0) {
            foreach($this->casualties as $casualty) {
                $this->removeUnit($casualty);
                $this->addLostUnit($casualty);
                $this->removeCasualty($casualty);
            }
        }

        $this->createUnitsByTypeAndTag();
    }

    /**
     *
     */
    public function orderUnits() {
        $this->orderUnitsByDefense();

        if($this->battle->getCalculator()->getSettings()->getKeepDestroyers()) {
            if(count($this->battle->getAttacker()->getUnitsByType(Submarine::class)) > 0) {
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
            $this->logger->info('ordering defender units', [array_map(function(Unit $unit) {
                return $unit->getName() . ' (' . $unit->getDefense() . ')';
            }, $this->units)]);
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
                return $b->getHitPoints() - $a->getHitPoints();
            }
            return $a->hasTag('chosen_last')? +1 : -1;
        });
    }

    /**
     * @return number
     */
    public function getCombatPower()
    {
        return array_sum(
            array_map(
                function(Unit $unit) {
                    return $unit->getDefense();
                }, $this->units
            )
        );
    }
}
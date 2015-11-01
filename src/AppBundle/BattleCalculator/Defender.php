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

class Defender extends Side
{

    /**
     * @param Unit[] $units
     * @param Logger $logger
     */
    function __construct($units, Logger $logger = null)
    {
        $this->logger = $logger;
        $this->units = $units;
        foreach($this->units as $unit)
            $unit->setSide($this);

        $this->orderUnits();
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

        $this->orderUnits();
        $this->createUnitsByTypeAndTag();
    }

    /**
     *
     */
    public function orderUnits() {
        $this->orderUnitsByDefense();

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


}
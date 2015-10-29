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

class Attacker extends Side
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

        $this->combineArms();

        $this->orderUnits();
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
    public function orderUnits() {
        $this->combineArms();
        $this->orderUnitsByAttack();

        if($this->logger)
            $this->logger->info('ordering attacker units', [array_map(function(Unit $unit) {
                return $unit->getName() . ' (' . $unit->getAttack() . ')';
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

}
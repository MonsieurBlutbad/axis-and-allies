<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 11:00
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\AirUnit;
use AppBundle\BattleCalculator\Unit\LandUnit;
use AppBundle\BattleCalculator\Unit\SeaUnit;
use AppBundle\BattleCalculator\Unit\Unit;

class SeaBattle extends Battle
{

    /**
     * Performs a single battle round.
     */
    public function round()
    {
        // TODO
        foreach($this->attacker->getUnits() as $unit) {
            /** @var Unit $unit */
            $unit->setHasShot(false);
        }
        foreach($this->defender->getUnits() as $unit) {
            /** @var Unit $unit */
            $unit->setHasShot(false);
        }

        // TODO outsource this to Side
        $this->surpriseStrike();
        $this->attacker->removeCasualties();
        $this->defender->removeCasualties();

        if( count($this->attacker->getUnits()) <= 0 || count($this->defender->getUnits()) <= 0 )
            return;

        $this->fire();
        $this->attacker->removeCasualties();
        $this->defender->removeCasualties();
    }

    /**
     *
     */
    protected function surpriseStrike()
    {
        if($this->logger) {
            $this->logger->info('Surprise Attack Attacker');
        }
        $unitsWithSurpriseStrike = $this->attacker->getUnitsByTag(Unit::SURPRISE_STRIKE);
        if(count($unitsWithSurpriseStrike) > 0) {
            if(! count($this->defender->getUnitsByTag(Unit::DENIES_SURPRISE_STRIKE)) > 0) {
                foreach($unitsWithSurpriseStrike as $unit) {
                    /* @var $unit Unit */
                    if($unit->getAttack() > 0) {
                        $this->attackRoll($unit, [SeaUnit::class]);
                    }
                }
            } else {
                if($this->logger) {
                    $this->logger->info('Surprise Attack denied by Unit with ' . Unit::DENIES_SURPRISE_STRIKE);
                }
            }
        } else {
            if($this->logger) {
                $this->logger->info('No units with surprise attack');
            }
        }
        if($this->logger) {
            $this->logger->info('Surprise Defender Defender');
        }
        $unitsWithSurpriseStrike = $this->defender->getUnitsByTag(Unit::SURPRISE_STRIKE);
        if(count($unitsWithSurpriseStrike) > 0) {
            if(! count($this->attacker->getUnitsByTag(Unit::DENIES_SURPRISE_STRIKE)) > 0) {
                foreach($unitsWithSurpriseStrike as $unit) {
                    /* @var $unit Unit */
                    if($unit->getDefense() > 0) {
                        $this->attackRoll($unit, [SeaUnit::class]);
                    }
                }
            } else {
                if($this->logger) {
                    $this->logger->info('Surprise Attack denied by Unit with ' . Unit::DENIES_SURPRISE_STRIKE);
                }
            }
    } else
            if($this->logger)
                $this->logger->info('No units with surprise attack');
    }

    /**
     * @param Unit $unit
     */
    protected function attackRoll(Unit $unit)
    {
        if($unit instanceof LandUnit) {
            if($this->logger)
                $this->logger->notice('Skip Unit', [$unit->getName(), [spl_object_hash($unit)]]);
            return;
        }

        parent::attackRoll($unit);
    }

}
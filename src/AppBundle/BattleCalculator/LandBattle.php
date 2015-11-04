<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 11:00
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\AirUnit;
use AppBundle\BattleCalculator\Unit\SeaUnit;
use AppBundle\BattleCalculator\Unit\Unit;

class LandBattle extends Battle
{

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

        $this->fire();

        $this->attacker->removeCasualties();
        $this->defender->removeCasualties();
    }

    /**
     * Performs any battle phases that happen before the first round of regular combat.
     */
    protected function beforeFirstRound()
    {
        // TODO outsource this to Defender
        $this->antiAirAttack();
        $this->attacker->removeCasualties();
    }

    /**
     * Performs AntiAirAttack
     */
    private function antiAirAttack()
    {
        if($this->logger)
            $this->logger->notice('Anti Air Attack');

        foreach($this->defender->getUnits() as $unit) {
            /* @var Unit $unit */
            if($unit->hasTag(Unit::AIR_DEFENSE)) {
                $attackerAirUnitCount = count($this->attacker->getUnitsByClass(AirUnit::class));

                if($this->logger)
                    $this->logger->info($unit->getName() . ' performs anti air attack', ['shots' => min(3, $attackerAirUnitCount), 'attackerAirUnitCount' => $attackerAirUnitCount, spl_object_hash($this)] );

                for($i = 0; $i < min(3, $attackerAirUnitCount); $i ++) {
                    if($this->hasHit(1))
                        $this->attacker->applyHit($unit, [AirUnit::class]);
                }
            }
        }
    }

    /**
     * @param Unit $unit
     */
    protected function attackRoll(Unit $unit)
    {
        if($unit instanceof SeaUnit) {
            if($this->logger)
                $this->logger->notice('Skip Unit', [$unit->getName(), [spl_object_hash($unit)]]);
            return;
        }

        parent::attackRoll($unit);
    }


}
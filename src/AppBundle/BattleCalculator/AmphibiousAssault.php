<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 11:00
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\SeaUnit;

class AmphibiousAssault extends LandBattle
{

    /**
     * Performs any battle phases that happen before the first round of regular combat.
     */
    protected function beforeFirstRound()
    {
        $this->coastalBombardment();

        parent::beforeFirstRound();
    }

    /**
     * Performs Coastal Bombardment.
     */
    private function coastalBombardment()
    {
        if($this->logger)
            $this->logger->notice('Coastal Bombardment begins');

        foreach($this->attacker->getUnitsByClass(SeaUnit::class) as $unit) {
            /* @var SeaUnit $unit */
            if($unit->getCoastalBombardment() > 0) {
                if($this->logger)
                    $this->logger->info($unit->getName() . ' performs coastal bombardment', [spl_object_hash($this)]);

                if( $this->hasHit($unit->getCoastalBombardment()) )
                    $this->defender->applyHit($unit);

                $this->attacker->removeUnit($unit);
            }
        }

        $this->removeCasualties();
    }

}
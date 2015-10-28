<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 10:56
 */

namespace AppBundle\BattleCalculator\CombinedArms;

use AppBundle\BattleCalculator\Unit\Unit;

class FighterDestroyer extends CombinedArms
{
    /**
     * @var array
     */
    protected static $tags = [Unit::DENIES_CANT_BE_HIT_BY_AIR_UNITS];

    /**
     * @return CombinedArms
     */
    public static function getInstance() {

        if ( is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
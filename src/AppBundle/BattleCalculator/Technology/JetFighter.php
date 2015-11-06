<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 10:56
 */

namespace AppBundle\BattleCalculator\Technology;

use AppBundle\BattleCalculator\Unit\Fighter;

class JetFighter extends Technology
{
    const NAME = 'jet_fighter';

    /**
     * @var integer
     */
    protected static $attack = 4;

    /**
     * @return array
     */
    public function getImproves()
    {
        return [Fighter::class];
    }

}
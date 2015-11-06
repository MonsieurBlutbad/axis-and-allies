<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 10:56
 */

namespace AppBundle\BattleCalculator\Technology;

use AppBundle\BattleCalculator\Unit\StrategicBomber;
use AppBundle\BattleCalculator\Unit\Unit;

class HeavyBomber extends Technology
{
    const NAME = 'heavy_bomber';

    /**
     * @var array
     */
    protected static $tags = [Unit::ATTACKS_TWICE];

    /**
     * @return array
     */
    public function getImproves()
    {
        return [StrategicBomber::class];
    }

}
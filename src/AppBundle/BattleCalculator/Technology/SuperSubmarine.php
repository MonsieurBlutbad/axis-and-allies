<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 10:56
 */

namespace AppBundle\BattleCalculator\Technology;

use AppBundle\BattleCalculator\Unit\Submarine;

class SuperSubmarine extends Technology
{
    const NAME = 'super_submarine';

    /**
     * @var integer
     */
    protected static $attack = 3;

    /**
     * @return array
     */
    public function getImproves()
    {
        return [Submarine::class];
    }

}
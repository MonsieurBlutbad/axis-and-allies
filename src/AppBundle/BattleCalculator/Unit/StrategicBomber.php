<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use AppBundle\BattleCalculator\CombinedArms\StrategicBomberDestroyer;
use Symfony\Bridge\Monolog\Logger;

class StrategicBomber extends AirUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'strategic_bomber';
        $this->cost = 12;
        $this->attack = 4;
        $this->defense = 1;
        $this->addCombination([Destroyer::class => StrategicBomberDestroyer::class]);

        parent::__construct($logger);
    }

}
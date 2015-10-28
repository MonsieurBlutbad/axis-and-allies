<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use AppBundle\BattleCalculator\CombinedArms\FighterDestroyer;
use Symfony\Bridge\Monolog\Logger;

class Fighter extends AirUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'fighter';
        $this->cost = 10;
        $this->attack = 3;
        $this->defense = 4;

        parent::__construct($logger);
    }

}
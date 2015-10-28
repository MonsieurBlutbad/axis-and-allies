<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use AppBundle\BattleCalculator\CombinedArms\TacticalBomberDestroyer;
use AppBundle\BattleCalculator\CombinedArms\TacticalBomberFighter;
use AppBundle\BattleCalculator\CombinedArms\TacticalBomberTank;
use Symfony\Bridge\Monolog\Logger;

class TacticalBomber extends AirUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'tactical_bomber';
        $this->cost = 11;
        $this->attack = 3;
        $this->defense = 3;
        $this->combinations[Fighter::class] = new TacticalBomberFighter();
        $this->combinations[Tank::class] = new TacticalBomberTank();

        parent::__construct($logger);
    }
}
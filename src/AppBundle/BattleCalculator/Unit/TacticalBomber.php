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
    const NAME    = 'tactical_bomber';
    const COST    = 11;
    const ATTACK  = 3;
    const DEFENSE = 3;
    const HIT_POINTS = 1;

    const LAND_BATTLE = true;
    const AMPHIBIOUS_ASSAULT = true;
    const SEA_BATTLE = true;

    function __construct(Logger $logger = null)
    {
        $this->name = self::NAME;
        $this->cost = self::COST;
        $this->attack = self::ATTACK;
        $this->defense = self::DEFENSE;
        $this->hitPoints = self::HIT_POINTS;

        $this->combinations[Fighter::class] = new TacticalBomberFighter();
        $this->combinations[Tank::class] = new TacticalBomberTank();

        parent::__construct($logger);
    }
}
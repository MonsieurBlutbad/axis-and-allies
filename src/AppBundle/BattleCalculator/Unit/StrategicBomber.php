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
    const NAME    = 'strategic_bomber';
    const COST    = 12;
    const ATTACK  = 4;
    const DEFENSE = 1;
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

        parent::__construct($logger);
    }

}
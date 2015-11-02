<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Artillery extends LandUnit
{
    const NAME    = 'artillery';
    const COST    = 4;
    const ATTACK  = 2;
    const DEFENSE = 2;
    const HIT_POINTS = 1;

    const LAND_BATTLE = true;
    const AMPHIBIOUS_ASSAULT = true;
    const SEA_BATTLE = false;

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
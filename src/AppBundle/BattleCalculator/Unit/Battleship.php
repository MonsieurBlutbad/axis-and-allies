<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Battleship extends SeaUnit
{
    const NAME    = 'battleship';
    const COST    = 20;
    const ATTACK  = 4;
    const DEFENSE = 4;
    const COASTAL_BOMBARDMENT = 4;
    const HIT_POINTS = 2;

    const LAND_BATTLE = false;
    const AMPHIBIOUS_ASSAULT = true;
    const SEA_BATTLE = true;

    function __construct(Logger $logger = null)
    {
        $this->name = self::NAME;
        $this->cost = self::COST;
        $this->attack = self::ATTACK;
        $this->defense = self::DEFENSE;
        $this->coastalBombardment = self::COASTAL_BOMBARDMENT;
        $this->hitPoints = self::HIT_POINTS;

        parent::__construct($logger);
    }

}
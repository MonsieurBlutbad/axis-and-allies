<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Cruiser extends SeaUnit
{
    const NAME    = 'cruiser';
    const COST    = 12;
    const ATTACK  = 3;
    const DEFENSE = 3;
    const COASTAL_BOMBARDMENT = 3;
    const HIT_POINTS = 1;

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
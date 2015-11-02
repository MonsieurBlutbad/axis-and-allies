<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class AircraftCarrier extends SeaUnit
{
    const NAME    = 'aircraft_carrier';
    const COST    = 16;
    const ATTACK  = 0;
    const DEFENSE = 2;
    const COASTAL_BOMBARDMENT = 0;
    const HIT_POINTS = 2;

    const LAND_BATTLE = false;
    const AMPHIBIOUS_ASSAULT = false;
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
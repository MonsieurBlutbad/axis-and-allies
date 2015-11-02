<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Submarine extends SeaUnit
{
    const NAME    = 'submarine';
    const COST    = 6;
    const ATTACK  = 2;
    const DEFENSE = 1;
    const COASTAL_BOMBARDMENT = 0;
    const HIT_POINTS = 1;

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

        $this->addTag(Unit::CANT_BE_HIT_BY_AIR_UNITS);
        $this->addTag(Unit::CANT_HIT_AIR_UNITS);
        $this->addTag(Unit::SURPRISE_STRIKE);

        parent::__construct($logger);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Destroyer extends SeaUnit
{
    const NAME    = 'destroyer';
    const COST    = 8;
    const ATTACK  = 2;
    const DEFENSE = 2;
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

        $this->addTag(Unit::DENIES_SURPRISE_STRIKE);
        $this->addTag(Unit::DENIES_CANT_BE_HIT_BY_AIR_UNITS);

        parent::__construct($logger);
    }

}
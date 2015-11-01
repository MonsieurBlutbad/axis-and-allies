<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class AntiaircraftArtillery extends LandUnit
{
    const NAME    = 'antiaircraft_artillery';
    const COST    = 5;
    const ATTACK  = 0;
    const DEFENSE = 0;
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

        $this->addTag(Unit::AIR_DEFENSE);
        $this->addTag(Unit::CANT_ATTACK);

        parent::__construct($logger);
    }

}
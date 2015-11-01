<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Transport extends SeaUnit
{
    const NAME    = 'transport';
    const COST    = 7;
    const ATTACK  = 0;
    const DEFENSE = 0;
    const COASTAL_BOMBARDMENT = 0;
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

        $this->addTag(Unit::CHOSEN_LAST);

        parent::__construct($logger);
    }

}
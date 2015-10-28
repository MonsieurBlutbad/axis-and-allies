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
    function __construct(Logger $logger = null)
    {
        $this->name = 'antiaircraft_artillery';
        $this->cost = 5;
        $this->attack = 0;
        $this->defense = 0;
        $this->addTag(Unit::AIR_DEFENSE);
        $this->addTag(Unit::CANT_ATTACK);

        parent::__construct($logger);
    }

}
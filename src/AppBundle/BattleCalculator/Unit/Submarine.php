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
    function __construct(Logger $logger = null)
    {
        $this->name = 'submarine';
        $this->cost = 6;
        $this->attack = 2;
        $this->defense = 1;
        $this->addTag(Unit::CANT_BE_HIT_BY_AIR_UNITS);
        $this->addTag(Unit::CANT_HIT_AIR_UNITS);
        $this->addTag(Unit::SURPRISE_STRIKE);

        parent::__construct($logger);
    }

}
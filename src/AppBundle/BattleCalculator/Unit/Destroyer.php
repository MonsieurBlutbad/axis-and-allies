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
    function __construct(Logger $logger = null)
    {
        $this->name = 'destroyer';
        $this->cost = 8;
        $this->attack = 2;
        $this->defense = 2;
        $this->addTag(Unit::DENIES_SURPRISE_STRIKE);
        $this->addTag(Unit::DENIES_CANT_BE_HIT_BY_AIR_UNITS);

        parent::__construct($logger);
    }

}
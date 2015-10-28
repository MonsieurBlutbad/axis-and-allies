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
    function __construct(Logger $logger = null)
    {
        $this->name = 'aircraft_carrier';
        $this->cost = 16;
        $this->attack = 0;
        $this->defense = 2;
        $this->hitPoints = 2;

        parent::__construct($logger);
    }

}
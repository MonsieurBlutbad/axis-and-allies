<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Battleship extends SeaUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'battleship';
        $this->cost = 20;
        $this->attack = 4;
        $this->defense = 4;
        $this->coastalBombardment = 4;
        $this->hitPoints = 2;

        parent::__construct($logger);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Cruiser extends SeaUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'cruiser';
        $this->cost = 12;
        $this->attack = 3;
        $this->defense = 3;
        $this->coastalBombardment = 3;

        parent::__construct($logger);
    }

}
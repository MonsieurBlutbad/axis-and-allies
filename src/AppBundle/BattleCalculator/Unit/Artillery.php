<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use Symfony\Bridge\Monolog\Logger;

class Artillery extends LandUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'artillery';
        $this->cost = 4;
        $this->attack = 2;
        $this->defense = 2;

        parent::__construct($logger);
    }

}
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
    function __construct(Logger $logger = null)
    {
        $this->name = 'transport';
        $this->cost = 7;
        $this->attack = 0;
        $this->defense = 0;
        $this->addTag(Unit::CHOSEN_LAST);

        parent::__construct($logger);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use AppBundle\BattleCalculator\CombinedArms\InfantryArtillery;
use Symfony\Bridge\Monolog\Logger;

class Infantry extends LandUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'infantry';
        $this->cost = 3;
        $this->attack = 1;
        $this->defense = 2;
        $this->combinations[Artillery::class] = new InfantryArtillery();

        parent::__construct($logger);
    }
}
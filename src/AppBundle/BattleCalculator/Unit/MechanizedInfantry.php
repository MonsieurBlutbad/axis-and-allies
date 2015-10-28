<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 09:31
 */
namespace AppBundle\BattleCalculator\Unit;

use AppBundle\BattleCalculator\CombinedArms\MechanizedInfantryArtillery;
use Symfony\Bridge\Monolog\Logger;

class MechanizedInfantry extends LandUnit
{
    function __construct(Logger $logger = null)
    {
        $this->name = 'mechanized_infantry';
        $this->cost = 4;
        $this->attack = 1;
        $this->defense = 2;
        $this->combinations[Artillery::class] = new MechanizedInfantryArtillery();

        parent::__construct($logger);
    }
}
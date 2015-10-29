<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 25.10.2015
 * Time: 10:29
 */

namespace AppBundle\BattleCalculator\Form;

use AppBundle\BattleCalculator\Calculator;
use AppBundle\BattleCalculator\Side;
use AppBundle\BattleCalculator\Unit\AircraftCarrier;
use AppBundle\BattleCalculator\Unit\AntiaircraftArtillery;
use AppBundle\BattleCalculator\Unit\Artillery;
use AppBundle\BattleCalculator\Unit\Battleship;
use AppBundle\BattleCalculator\Unit\Cruiser;
use AppBundle\BattleCalculator\Unit\Destroyer;
use AppBundle\BattleCalculator\Unit\Fighter;
use AppBundle\BattleCalculator\Unit\Infantry;
use AppBundle\BattleCalculator\Unit\MechanizedInfantry;
use AppBundle\BattleCalculator\Unit\StrategicBomber;
use AppBundle\BattleCalculator\Unit\Submarine;
use AppBundle\BattleCalculator\Unit\TacticalBomber;
use AppBundle\BattleCalculator\Unit\Tank;
use AppBundle\BattleCalculator\Unit\Transport;
use Symfony\Bridge\Monolog\Logger;

class BattleForm
{
    /**
     * var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $accuracy;

    protected $test = ['infantry' => 0];

    /**
     * @var int;
     */
    protected $attackerInfantry = 0;

    /**
     * @var int;
     */
    protected $attackerMechanizedInfantry = 0;

    /**
     * @var int;
     */
    protected $attackerArtillery = 0;

    /**
     * @var int;
     */
    protected $attackerTank = 0;

    /**
     * @var int;
     */
    protected $attackerFighter = 0;

    /**
     * @var int;
     */
    protected $attackerTacticalBomber = 0;

    /**
     * @var int;
     */
    protected $attackerStrategicBomber = 0;

    /**
     * @var int;
     */
    protected $attackerTransport = 0;

    /**
     * @var int;
     */
    protected $attackerSubmarine = 0;

    /**
     * @var int;
     */
    protected $attackerDestroyer = 0;

    /**
     * @var int;
     */
    protected $attackerCruiser = 0;

    /**
     * @var int;
     */
    protected $attackerAircraftCarrier = 0;

    /**
     * @var int;
     */
    protected $attackerBattleship = 0;

    /**
     * @var int;
     */
    protected $defenderInfantry = 0;

    /**
     * @var int;
     */
    protected $defenderMechanizedInfantry = 0;

    /**
     * @var int;
     */
    protected $defenderArtillery = 0;

    /**
     * @var int;
     */
    protected $defenderTank = 0;

    /**
     * @var int;
     */
    protected $defenderAntiaircraftArtillery = 0;

    /**
     * @var int;
     */
    protected $defenderFighter = 0;

    /**
     * @var int;
     */
    protected $defenderTacticalBomber = 0;

    /**
     * @var int;
     */
    protected $defenderStrategicBomber = 0;

    /**
     * @var int;
     */
    protected $defenderTransport = 0;

    /**
     * @var int;
     */
    protected $defenderSubmarine = 0;

    /**
     * @var int;
     */
    protected $defenderDestroyer = 0;

    /**
     * @var int;
     */
    protected $defenderCruiser = 0;

    /**
     * @var int;
     */
    protected $defenderAircraftCarrier = 0;

    /**
     * @var int;
     */
    protected $defenderBattleship = 0;

    /**
     * @var array
     */
    protected $allowedClasses = [
        Calculator::LAND_BATTLE => [
            'attacker' => [
                Infantry::class,
                MechanizedInfantry::class,
                Artillery::class,
                Tank::class,
                Fighter::class,
                TacticalBomber::class,
                StrategicBomber::class,
            ],
            'defender' => [
                Infantry::class,
                MechanizedInfantry::class,
                Artillery::class,
                Tank::class,
                AntiaircraftArtillery::class,
                Fighter::class,
                TacticalBomber::class,
                StrategicBomber::class,
            ]
        ],
        Calculator::AMPHIBIOUS_ASSAULT => [
            'attacker' => [
                Infantry::class,
                MechanizedInfantry::class,
                Artillery::class,
                Tank::class,
                Fighter::class,
                TacticalBomber::class,
                StrategicBomber::class,
                Cruiser::class,
                Battleship::class,
            ],
            'defender' => [
                Infantry::class,
                MechanizedInfantry::class,
                Artillery::class,
                Tank::class,
                AntiaircraftArtillery::class,
                Fighter::class,
                TacticalBomber::class,
                StrategicBomber::class,
            ]
        ],
        Calculator::SEA_BATTLE => [
            'attacker' => [
                Fighter::class,
                TacticalBomber::class,
                StrategicBomber::class,
                Transport::class,
                Submarine::class,
                Destroyer::class,
                Cruiser::class,
                AircraftCarrier::class,
                Battleship::class,
            ],
            'defender' => [
                Fighter::class,
                TacticalBomber::class,
                StrategicBomber::class,
                Transport::class,
                Submarine::class,
                Destroyer::class,
                Cruiser::class,
                AircraftCarrier::class,
                Battleship::class,
            ]
        ]
    ];

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * @param int $accuracy
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    }

    /**
     * @param Logger $logger
     * @return array
     */
    public function getUnits(Logger $logger = null)
    {
        $units = [
            Side::ATTACKER => [],
            Side::DEFENDER => [],
        ];
        $namespace = 'AppBundle\\BattleCalculator\\Unit';
        foreach($this as $key => $value) {
            if($value > 0) {
                if(preg_match('/^.*(' . Side::ATTACKER . '|' . Side::DEFENDER . ')(\w+)$/', $key, $matches)) {
                    $side =$matches[1];
                    $class = $matches[2];
                    $className = $namespace . '\\' . $class;
                    if($this->isClassAllowedForType($side, $className)) {
                        for($i = 0; $i < $value; $i++) {
                            $units[$side][] = new $className($logger);
                        }
                    }
                }
            }
        }
        return $units;
    }

    /**
     * @param $side
     * @param $class
     * @return bool
     */
    protected function isClassAllowedForType($side, $class)
    {
        return in_array($class, $this->allowedClasses[$this->type][$side]);
    }

}
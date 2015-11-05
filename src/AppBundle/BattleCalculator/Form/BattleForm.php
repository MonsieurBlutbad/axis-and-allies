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

    /**
     * @var boolean
     */
    protected $mustTakeTerritory = false;

    /**
     * @var int;
     */
    protected $attackerInfantry;

    /**
     * @var int;
     */
    protected $attackerMechanizedInfantry;

    /**
     * @var int;
     */
    protected $attackerArtillery;

    /**
     * @var int;
     */
    protected $attackerTank;

    /**
     * @var int;
     */
    protected $attackerFighter;

    /**
     * @var int;
     */
    protected $attackerTacticalBomber;

    /**
     * @var int;
     */
    protected $attackerStrategicBomber;

    /**
     * @var int;
     */
    protected $attackerTransport;

    /**
     * @var int;
     */
    protected $attackerSubmarine;

    /**
     * @var int;
     */
    protected $attackerDestroyer;

    /**
     * @var int;
     */
    protected $attackerCruiser;

    /**
     * @var int;
     */
    protected $attackerAircraftCarrier;

    /**
     * @var int;
     */
    protected $attackerBattleship;

    /**
     * @var int;
     */
    protected $defenderInfantry;

    /**
     * @var int;
     */
    protected $defenderMechanizedInfantry;

    /**
     * @var int;
     */
    protected $defenderArtillery;

    /**
     * @var int;
     */
    protected $defenderTank;

    /**
     * @var int;
     */
    protected $defenderAntiaircraftArtillery;

    /**
     * @var int;
     */
    protected $defenderFighter;

    /**
     * @var int;
     */
    protected $defenderTacticalBomber;

    /**
     * @var int;
     */
    protected $defenderStrategicBomber;

    /**
     * @var int;
     */
    protected $defenderTransport;

    /**
     * @var int;
     */
    protected $defenderSubmarine;

    /**
     * @var int;
     */
    protected $defenderDestroyer;

    /**
     * @var int;
     */
    protected $defenderCruiser;

    /**
     * @var int;
     */
    protected $defenderAircraftCarrier;

    /**
     * @var int;
     */
    protected $defenderBattleship;

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
     * @return boolean
     */
    public function getMustTakeTerritory()
    {
        return $this->mustTakeTerritory;
    }

    /**
     * @param boolean $mustTakeTerritory
     */
    public function setMustTakeTerritory($mustTakeTerritory)
    {
        $this->mustTakeTerritory = $mustTakeTerritory;
    }

    /**
     * @return int
     */
    public function getAttackerInfantry()
    {
        return $this->attackerInfantry;
    }

    /**
     * @param int $attackerInfantry
     */
    public function setAttackerInfantry($attackerInfantry)
    {
        $this->attackerInfantry = $attackerInfantry;
    }

    /**
     * @return int
     */
    public function getAttackerMechanizedInfantry()
    {
        return $this->attackerMechanizedInfantry;
    }

    /**
     * @param int $attackerMechanizedInfantry
     */
    public function setAttackerMechanizedInfantry($attackerMechanizedInfantry)
    {
        $this->attackerMechanizedInfantry = $attackerMechanizedInfantry;
    }

    /**
     * @return int
     */
    public function getAttackerArtillery()
    {
        return $this->attackerArtillery;
    }

    /**
     * @param int $attackerArtillery
     */
    public function setAttackerArtillery($attackerArtillery)
    {
        $this->attackerArtillery = $attackerArtillery;
    }

    /**
     * @return int
     */
    public function getAttackerTank()
    {
        return $this->attackerTank;
    }

    /**
     * @param int $attackerTank
     */
    public function setAttackerTank($attackerTank)
    {
        $this->attackerTank = $attackerTank;
    }

    /**
     * @return int
     */
    public function getAttackerFighter()
    {
        return $this->attackerFighter;
    }

    /**
     * @param int $attackerFighter
     */
    public function setAttackerFighter($attackerFighter)
    {
        $this->attackerFighter = $attackerFighter;
    }

    /**
     * @return int
     */
    public function getAttackerTacticalBomber()
    {
        return $this->attackerTacticalBomber;
    }

    /**
     * @param int $attackerTacticalBomber
     */
    public function setAttackerTacticalBomber($attackerTacticalBomber)
    {
        $this->attackerTacticalBomber = $attackerTacticalBomber;
    }

    /**
     * @return int
     */
    public function getAttackerStrategicBomber()
    {
        return $this->attackerStrategicBomber;
    }

    /**
     * @param int $attackerStrategicBomber
     */
    public function setAttackerStrategicBomber($attackerStrategicBomber)
    {
        $this->attackerStrategicBomber = $attackerStrategicBomber;
    }

    /**
     * @return int
     */
    public function getAttackerTransport()
    {
        return $this->attackerTransport;
    }

    /**
     * @param int $attackerTransport
     */
    public function setAttackerTransport($attackerTransport)
    {
        $this->attackerTransport = $attackerTransport;
    }

    /**
     * @return int
     */
    public function getAttackerSubmarine()
    {
        return $this->attackerSubmarine;
    }

    /**
     * @param int $attackerSubmarine
     */
    public function setAttackerSubmarine($attackerSubmarine)
    {
        $this->attackerSubmarine = $attackerSubmarine;
    }

    /**
     * @return int
     */
    public function getAttackerDestroyer()
    {
        return $this->attackerDestroyer;
    }

    /**
     * @param int $attackerDestroyer
     */
    public function setAttackerDestroyer($attackerDestroyer)
    {
        $this->attackerDestroyer = $attackerDestroyer;
    }

    /**
     * @return int
     */
    public function getAttackerCruiser()
    {
        return $this->attackerCruiser;
    }

    /**
     * @param int $attackerCruiser
     */
    public function setAttackerCruiser($attackerCruiser)
    {
        $this->attackerCruiser = $attackerCruiser;
    }

    /**
     * @return int
     */
    public function getAttackerAircraftCarrier()
    {
        return $this->attackerAircraftCarrier;
    }

    /**
     * @param int $attackerAircraftCarrier
     */
    public function setAttackerAircraftCarrier($attackerAircraftCarrier)
    {
        $this->attackerAircraftCarrier = $attackerAircraftCarrier;
    }

    /**
     * @return int
     */
    public function getAttackerBattleship()
    {
        return $this->attackerBattleship;
    }

    /**
     * @param int $attackerBattleship
     */
    public function setAttackerBattleship($attackerBattleship)
    {
        $this->attackerBattleship = $attackerBattleship;
    }

    /**
     * @return int
     */
    public function getDefenderInfantry()
    {
        return $this->defenderInfantry;
    }

    /**
     * @param int $defenderInfantry
     */
    public function setDefenderInfantry($defenderInfantry)
    {
        $this->defenderInfantry = $defenderInfantry;
    }

    /**
     * @return int
     */
    public function getDefenderMechanizedInfantry()
    {
        return $this->defenderMechanizedInfantry;
    }

    /**
     * @param int $defenderMechanizedInfantry
     */
    public function setDefenderMechanizedInfantry($defenderMechanizedInfantry)
    {
        $this->defenderMechanizedInfantry = $defenderMechanizedInfantry;
    }

    /**
     * @return int
     */
    public function getDefenderArtillery()
    {
        return $this->defenderArtillery;
    }

    /**
     * @param int $defenderArtillery
     */
    public function setDefenderArtillery($defenderArtillery)
    {
        $this->defenderArtillery = $defenderArtillery;
    }

    /**
     * @return int
     */
    public function getDefenderTank()
    {
        return $this->defenderTank;
    }

    /**
     * @param int $defenderTank
     */
    public function setDefenderTank($defenderTank)
    {
        $this->defenderTank = $defenderTank;
    }

    /**
     * @return int
     */
    public function getDefenderAntiaircraftArtillery()
    {
        return $this->defenderAntiaircraftArtillery;
    }

    /**
     * @param int $defenderAntiaircraftArtillery
     */
    public function setDefenderAntiaircraftArtillery($defenderAntiaircraftArtillery)
    {
        $this->defenderAntiaircraftArtillery = $defenderAntiaircraftArtillery;
    }

    /**
     * @return int
     */
    public function getDefenderFighter()
    {
        return $this->defenderFighter;
    }

    /**
     * @param int $defenderFighter
     */
    public function setDefenderFighter($defenderFighter)
    {
        $this->defenderFighter = $defenderFighter;
    }

    /**
     * @return int
     */
    public function getDefenderTacticalBomber()
    {
        return $this->defenderTacticalBomber;
    }

    /**
     * @param int $defenderTacticalBomber
     */
    public function setDefenderTacticalBomber($defenderTacticalBomber)
    {
        $this->defenderTacticalBomber = $defenderTacticalBomber;
    }

    /**
     * @return int
     */
    public function getDefenderStrategicBomber()
    {
        return $this->defenderStrategicBomber;
    }

    /**
     * @param int $defenderStrategicBomber
     */
    public function setDefenderStrategicBomber($defenderStrategicBomber)
    {
        $this->defenderStrategicBomber = $defenderStrategicBomber;
    }

    /**
     * @return int
     */
    public function getDefenderTransport()
    {
        return $this->defenderTransport;
    }

    /**
     * @param int $defenderTransport
     */
    public function setDefenderTransport($defenderTransport)
    {
        $this->defenderTransport = $defenderTransport;
    }

    /**
     * @return int
     */
    public function getDefenderSubmarine()
    {
        return $this->defenderSubmarine;
    }

    /**
     * @param int $defenderSubmarine
     */
    public function setDefenderSubmarine($defenderSubmarine)
    {
        $this->defenderSubmarine = $defenderSubmarine;
    }

    /**
     * @return int
     */
    public function getDefenderDestroyer()
    {
        return $this->defenderDestroyer;
    }

    /**
     * @param int $defenderDestroyer
     */
    public function setDefenderDestroyer($defenderDestroyer)
    {
        $this->defenderDestroyer = $defenderDestroyer;
    }

    /**
     * @return int
     */
    public function getDefenderCruiser()
    {
        return $this->defenderCruiser;
    }

    /**
     * @param int $defenderCruiser
     */
    public function setDefenderCruiser($defenderCruiser)
    {
        $this->defenderCruiser = $defenderCruiser;
    }

    /**
     * @return int
     */
    public function getDefenderAircraftCarrier()
    {
        return $this->defenderAircraftCarrier;
    }

    /**
     * @param int $defenderAircraftCarrier
     */
    public function setDefenderAircraftCarrier($defenderAircraftCarrier)
    {
        $this->defenderAircraftCarrier = $defenderAircraftCarrier;
    }

    /**
     * @return int
     */
    public function getDefenderBattleship()
    {
        return $this->defenderBattleship;
    }

    /**
     * @param int $defenderBattleship
     */
    public function setDefenderBattleship($defenderBattleship)
    {
        $this->defenderBattleship = $defenderBattleship;
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
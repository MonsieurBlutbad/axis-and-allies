<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 25.10.2015
 * Time: 10:29
 */

namespace AppBundle\BattleCalculator\Form;

class BattleCalculatorForm
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


}
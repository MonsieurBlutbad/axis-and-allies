<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 12:42
 */

namespace AppBundle\BattleCalculator;

class Calculation {

    /**
     * @var float
     */
    protected $accuracy = 0;
    
    /**
     * @var float
     */
    protected $attackerWins = 0.0;
    
    /**
     * @var float
     */
    protected $attackerRemainingUnits = 0.0;

    /**
     * @var float
     */
    protected $attackerLostUnits = 0.0;

    /**
     * @var float
     */
    protected $attackerLostIpc = 0.0;
    
    /**
     * @var float
     */
    protected $defenderRemainingUnits = 0.0;

    /**
     * @var float
     */
    protected $defenderLostUnits = 0.0;

    /**
     * @var float
     */
    protected $defenderLostIpc = 0.0;

    function __construct($results) {
        $this->setAccuracy(count($results));
        $attackerWinsTotal = 0;
        $attackerRemainingUnitsTotal = 0;
        $attackerLostUnitsTotal = 0;
        $attackerLostIpcTotal = 0;
        $defenderRemainingUnitsTotal = 0;
        $defenderLostUnitsTotal = 0;
        $defenderLostIpcTotal = 0;
        foreach($results as $result) {
            /* @var $result Result */
            if($result->getWinner() === Side::ATTACKER)
                $attackerWinsTotal ++;
            $attackerRemainingUnitsTotal += $result->getAttackerRemainingUnits();
            $attackerLostUnitsTotal      += $result->getAttackerLostUnits();
            $attackerLostIpcTotal        += $result->getAttackerLostIpc();
            $defenderRemainingUnitsTotal += $result->getDefenderRemainingUnits();
            $defenderLostUnitsTotal      += $result->getDefenderLostUnits();
            $defenderLostIpcTotal        += $result->getDefenderLostIpc();
        }
        $this->setAttackerWins($attackerWinsTotal / $this->getAccuracy());
        $this->setAttackerRemainingUnits($attackerRemainingUnitsTotal / $this->getAccuracy());
        $this->setAttackerLostUnits($attackerLostUnitsTotal / $this->getAccuracy());
        $this->setAttackerLostIpc($attackerLostIpcTotal / $this->getAccuracy());
        $this->setDefenderRemainingUnits($defenderRemainingUnitsTotal / $this->getAccuracy());
        $this->setDefenderLostUnits($defenderLostUnitsTotal / $this->getAccuracy());
        $this->setDefenderLostIpc($defenderLostIpcTotal / $this->getAccuracy());
    }

    /**
     * @return float
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * @param float $accuracy
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    }

    /**
     * @return float
     */
    public function getAttackerWins()
    {
        return $this->attackerWins;
    }

    /**
     * @return float
     */
    public function getDefenderWins()
    {
        return 1 - $this->getAttackerWins();
    }

    /**
     * @param float $attackerWins
     */
    public function setAttackerWins($attackerWins)
    {
        $this->attackerWins = $attackerWins;
    }

    /**
     * @return float
     */
    public function getAttackerRemainingUnits()
    {
        return $this->attackerRemainingUnits;
    }

    /**
     * @param float $attackerRemainingUnits
     */
    public function setAttackerRemainingUnits($attackerRemainingUnits)
    {
        $this->attackerRemainingUnits = $attackerRemainingUnits;
    }

    /**
     * @return float
     */
    public function getAttackerLostUnits()
    {
        return $this->attackerLostUnits;
    }

    /**
     * @param float $attackerLostUnits
     */
    public function setAttackerLostUnits($attackerLostUnits)
    {
        $this->attackerLostUnits = $attackerLostUnits;
    }

    /**
     * @return float
     */
    public function getAttackerLostIpc()
    {
        return $this->attackerLostIpc;
    }

    /**
     * @param float $attackerLostIpc
     */
    public function setAttackerLostIpc($attackerLostIpc)
    {
        $this->attackerLostIpc = $attackerLostIpc;
    }

    /**
     * @return float
     */
    public function getDefenderRemainingUnits()
    {
        return $this->defenderRemainingUnits;
    }

    /**
     * @param float $defenderRemainingUnits
     */
    public function setDefenderRemainingUnits($defenderRemainingUnits)
    {
        $this->defenderRemainingUnits = $defenderRemainingUnits;
    }

    /**
     * @return float
     */
    public function getDefenderLostUnits()
    {
        return $this->defenderLostUnits;
    }

    /**
     * @param float $defenderLostUnits
     */
    public function setDefenderLostUnits($defenderLostUnits)
    {
        $this->defenderLostUnits = $defenderLostUnits;
    }

    /**
     * @return float
     */
    public function getDefenderLostIpc()
    {
        return $this->defenderLostIpc;
    }

    /**
     * @param float $defenderLostIpc
     */
    public function setDefenderLostIpc($defenderLostIpc)
    {
        $this->defenderLostIpc = $defenderLostIpc;
    }



}
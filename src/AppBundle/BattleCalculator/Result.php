<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 12:42
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\Unit;

class Result {

    /**
     * @var string
     */
    protected $winner = '';
    
    /**
     * @var int
     */
    protected $attackerRemainingUnits = 0;

    /**
     * @var int
     */
    protected $attackerLostUnits = 0;

    /**
     * @var int
     */
    protected $attackerLostIpc = 0;
    
    /**
     * @var int
     */
    protected $defenderRemainingUnits = 0;

    /**
     * @var int
     */
    protected $defenderLostUnits = 0;

    /**
     * @var int
     */
    protected $defenderLostIpc = 0;

    function __construct(Battle $battle) {
        $this->setWinner($battle->getWinner());
        $this->setAttackerRemainingUnits(count($battle->getAttacker()->getUnits()));
        $this->setAttackerLostUnits(count($battle->getAttacker()->getLostUnits()));
        $this->setAttackerLostIpc($this->getIpcValue($battle->getAttacker()->getLostUnits()));
        $this->setDefenderRemainingUnits(count($battle->getDefender()->getUnits()));
        $this->setDefenderLostUnits(count($battle->getDefender()->getLostUnits()));
        $this->setDefenderLostIpc($this->getIpcValue($battle->getDefender()->getLostUnits()));
    }

    /**
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param string $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingUnits()
    {
        return $this->attackerRemainingUnits;
    }

    /**
     * @param int $attackerRemainingUnits
     */
    public function setAttackerRemainingUnits($attackerRemainingUnits)
    {
        $this->attackerRemainingUnits = $attackerRemainingUnits;
    }

    /**
     * @return int
     */
    public function getAttackerLostUnits()
    {
        return $this->attackerLostUnits;
    }

    /**
     * @param int $attackerLostUnits
     */
    public function setAttackerLostUnits($attackerLostUnits)
    {
        $this->attackerLostUnits = $attackerLostUnits;
    }

    /**
     * @return int
     */
    public function getAttackerLostIpc()
    {
        return $this->attackerLostIpc;
    }

    /**
     * @param int $attackerLostIpc
     */
    public function setAttackerLostIpc($attackerLostIpc)
    {
        $this->attackerLostIpc = $attackerLostIpc;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingUnits()
    {
        return $this->defenderRemainingUnits;
    }

    /**
     * @param int $defenderRemainingUnits
     */
    public function setDefenderRemainingUnits($defenderRemainingUnits)
    {
        $this->defenderRemainingUnits = $defenderRemainingUnits;
    }

    /**
     * @return int
     */
    public function getDefenderLostUnits()
    {
        return $this->defenderLostUnits;
    }

    /**
     * @param int $defenderLostUnits
     */
    public function setDefenderLostUnits($defenderLostUnits)
    {
        $this->defenderLostUnits = $defenderLostUnits;
    }

    /**
     * @return int
     */
    public function getDefenderLostIpc()
    {
        return $this->defenderLostIpc;
    }

    /**
     * @param int $defenderLostIpc
     */
    public function setDefenderLostIpc($defenderLostIpc)
    {
        $this->defenderLostIpc = $defenderLostIpc;
    }


    /**
     * @param Unit[] $units
     * @return int
     */
    private function getIpcValue($units) {
        $ipcValue = 0;
        foreach($units as $unit) {
            /* @var $unit Unit */
            $ipcValue += $unit->getCost();
        }
        return $ipcValue;
    }

}
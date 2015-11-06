<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 18.10.2015
 * Time: 11:00
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Unit\AirUnit;
use AppBundle\BattleCalculator\Unit\Unit;
use Symfony\Bridge\Monolog\Logger;

abstract class Battle
{
    /**
     * @var Side
     */
    protected $attacker;

    /**
     * @var Side
     */
    protected $defender;

    /**
     * @var BattleResult
     */
    protected $result;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Calculator
     */
    protected $calculator;

    function __construct($attackingUnits, $defendingUnits, Calculator $calculator, Logger $logger = null) {
        $this->logger = $logger;
        $this->calculator = $calculator;
        $this->attacker = new Attacker($attackingUnits, $this, $logger);
        $this->defender = new Defender($defendingUnits, $this, $logger);
        $this->attacker->setTechnologies($calculator->getTechnologies()[Side::ATTACKER]);
        $this->defender->setTechnologies($calculator->getTechnologies()[Side::DEFENDER]);
        $this->attacker->applyTechnologies();
        $this->defender->applyTechnologies();
        $this->attacker->orderUnits();
        $this->defender->orderUnits();
    }

    /**
     * @return Side
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * @return Side
     */
    public function getDefender()
    {
        return $this->defender;
    }

    /**
     * Returns the result of a single Battle
     */
    public function getResult()
    {

        if($this->logger)
            $this->logger->notice('Before First Round Phase begins');

        $this->beforeFirstRound();

        if($this->logger)
            $this->logger->notice('Main Battle Phase begins');

        $round = 0;
        while(count($this->attacker->getUnits()) > 0 && count($this->defender->getUnits()) > 0 && !$this->isStalemate()) {
            $round ++;
            if($this->logger)
                $this->logger->notice('New Battle Round', ['round' => $round]);

            $this->round();

            if($this->logger)
                $this->logger->notice('End of Battle Round', ['round' => $round, 'attackerRemainingUnits' => count($this->attacker->getUnits()), 'defenderRemainingUnits' => count($this->defender->getUnits())]);
        }

        $this->result = (new BattleResult($this));

        return $this->result;
    }

    /**
     * Performs any battle phases that happen before the first round of regular combat.
     */
    protected function beforeFirstRound()
    {
    }

    /**
     * Performs a single battle round.
     */
    abstract function round();

    /**
     *
     */
    protected function fire()
    {
        if($this->logger)
            $this->logger->notice('Attacker rolls');

        foreach($this->attacker->getUnits() as $unit) {
            /* @var $unit Unit */
            if($unit->getAttack() > 0 && ! $unit->getHasShot())
                $this->attackRoll($unit, Side::ATTACKER);
        }

        if($this->logger)
        $this->logger->notice('Defender rolls');

        foreach($this->defender->getUnits() as $unit) {
            /* @var $unit Unit */
            if ($unit->getDefense() > 0 && ! $unit->getHasShot())
                $this->attackRoll($unit, Side::DEFENDER);
        }
    }


    /**
     * @param Unit $unit
     */
    protected function attackRoll(Unit $unit)
    {
        if($this->logger)
            $this->logger->info($unit->getName() . ' rolls', [spl_object_hash($unit)]);

        if($unit->getSide() instanceof Attacker) {
            if($this->hasHit($unit->getAttack())) {
                $this->defender->applyHit($unit);
            } elseif($unit->hasTag(Unit::ATTACKS_TWICE)) {
                if ($this->hasHit($unit->getAttack())) {
                    $this->defender->applyHit($unit);
                }
            }

            $unit->setHasShot(true);
        }
        elseif($unit->getSide() instanceof Defender) {
            if($this->hasHit($unit->getDefense())) {
                $this->attacker->applyHit($unit);
            }

            $unit->setHasShot(true);
        }

    }

    /**
     * Returns the Side of the Winner.
     *
     * @return null|string
     */
    public function getWinner() {
        if($this->logger)
            $this->logger->notice(
                'Winner',
                [
                    count($this->attacker->getUnits()) <= 0
                        ? Side::DEFENDER
                        : (count($this->defender->getUnits()) <= 0
                            ? Side::ATTACKER
                            : null
                        )
                ]
            );

        if(count($this->attacker->getUnits()) <= 0)
            return Side::DEFENDER;
        if(count($this->defender->getUnits()) <= 0)
            return Side::ATTACKER;
        return null;
    }

    /**
     * @return bool
     */
    protected function isStalemate()
    {
        $attackerCantAttack = false;
        $defenderCantAttack = false;
        if(
            count($this->attacker->getUnitsByTag(Unit::CANT_HIT_AIR_UNITS)) === count($this->attacker->getUnits())
            && count($this->defender->getUnitsByType(AirUnit::class)) === count($this->defender->getUnits())
        )
            $attackerCantAttack = true;
        if(
            count($this->attacker->getUnitsByType(AirUnit::class)) === count($this->attacker->getUnits())
            && count($this->defender->getUnitsByTag(Unit::CANT_BE_HIT_BY_AIR_UNITS)) === count($this->defender->getUnits())
        )
            $attackerCantAttack = true;
        if(
            count($this->defender->getUnitsByTag(Unit::CANT_HIT_AIR_UNITS)) === count($this->defender->getUnits())
            && count($this->attacker->getUnitsByType(AirUnit::class)) === count($this->attacker->getUnits())
        )
            $defenderCantAttack = true;
        if(
            count($this->defender->getUnitsByType(AirUnit::class)) === count($this->defender->getUnits())
            && count($this->attacker->getUnitsByTag(Unit::CANT_BE_HIT_BY_AIR_UNITS)) === count($this->attacker->getUnits())
        )
            $defenderCantAttack = true;
        $stalemate = $attackerCantAttack && $defenderCantAttack;
        if($this->logger)
            $this->logger->info('stalemate check', [$stalemate]);
        return $stalemate;
    }

    /**
     * Returns true, if a unit has hit.
     *
     * @param $attackValue
     * @return bool
     */
    protected function hasHit($attackValue)
    {
        $diceRoll = $this->getDiceRoll();
        $hasHit = $diceRoll <= $attackValue;
        if($this->logger)
            $this->logger->info($hasHit? 'Hit' : 'Miss', ['attackValue' => $attackValue, 'diceRoll' => $diceRoll]);
        return $hasHit;
    }

    /**
     * Simulates a dice roll.
     *
     * @param int $dice
     * @return int
     */
    protected function getDiceRoll($dice = 6)
    {
        mt_srand();
        return mt_rand(1, $dice);
    }

    /**
     * @return Calculator
     */
    public function getCalculator()
    {
        return $this->calculator;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 23.10.2015
 * Time: 14:09
 */

namespace AppBundle\BattleCalculator;

use AppBundle\BattleCalculator\Form\BattleForm;
use AppBundle\BattleCalculator\Unit\Unit;
use Symfony\Bridge\Monolog\Logger;

class Calculator
{
    const LAND_BATTLE         = 'land_battle';
    const AMPHIBIOUS_ASSAULT  = 'amphibious_assault';
    const SEA_BATTLE          = 'sea_battle';

    /**
     * @var string
     */
    private $type;

    /**
     * @var Unit[]
     */
    private $attackerUnits;

    /**
     * @var Unit[]
     */
    private $defenderUnits;

    /**
     * @var array
     */
    private $technologies;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var BattleResult[]
     */
    private $results = [];

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param $form
     * @param Logger $logger
     */
    function __construct(BattleForm $form, Logger $logger = null)
    {
        $units = $form->getUnits($logger);
        $this->attackerUnits = $units['attacker'];
        $this->defenderUnits = $units['defender'];
        $this->technologies  = $form->getTechnologies($logger);

        $this->settings = new Settings( intval($form->getAccuracy()), true );

        $this->type = $form->getType();
        if(! in_array($this->type, [self::LAND_BATTLE, self::AMPHIBIOUS_ASSAULT, self::SEA_BATTLE]))
            throw new \InvalidArgumentException();

        if(in_array($this->type, [self::LAND_BATTLE, self::AMPHIBIOUS_ASSAULT])) {
            $this->settings->setMustTakeTerritory($form->getMustTakeTerritory());
        }

        if($this->type === self::SEA_BATTLE) {
            $this->settings->setKeepDestroyers($form->getKeepDestroyers());
        }

        if($logger && $this->settings->getDebug()) {
            // TODO
          //  $this->clearLog();
            $this->logger = $logger;
        }
        else
            $this->settings->setDebug(false);

        if($this->logger) {
            $this->logger->notice(
                'Battle Calculation started',
                [
                    'type' => $this->type,
                    'accuracy' => $this->settings->getAccuracy(),
                    'debug' => $this->settings->getDebug()
                ]
            );
            $this->logger->info(
                'Attacker has ' . count($this->attackerUnits) . ' units',
                [array_map(function(Unit $unit) {return $unit->getName(); }, $this->attackerUnits)]
            );
            $this->logger->info(
                'Defender has ' . count($this->defenderUnits) . ' units',
                [array_map(function(Unit $unit) {return $unit->getName(); }, $this->defenderUnits)]
            );
        }
    }

    /**
     * Loops through all battles and returns their result in an array.
     *
     * @return BattleResult[]
     */
    public function getResults()
    {
        for($i = 0; $i < $this->settings->getAccuracy(); $i++) {

            /** @var Battle $battle */
            // Use of array_map method to clone a new set of units for each battle
            switch($this->type) {

                case self::LAND_BATTLE:
                    if($this->logger)
                        $this->logger->notice(
                            'New Land Battle',
                            ['Iteration' => $i + 1, 'Total' => $this->settings->getAccuracy()]
                        );

                    $battle = new LandBattle(
                        array_map( function($unit) {
                            return clone $unit;
                        }, $this->attackerUnits),
                        array_map( function($unit) {
                            return clone $unit;
                        },$this->defenderUnits),
                        $this,
                        $this->logger
                    );
                    break;

                case self::AMPHIBIOUS_ASSAULT:
                    if($this->logger)
                        $this->logger->notice(
                            'New Amphibious Assault',
                            ['Iteration' => $i + 1, 'Total' => $this->settings->getAccuracy()]
                        );

                    $battle = new AmphibiousAssault(
                        array_map( function($unit) {
                            return clone $unit;
                        }, $this->attackerUnits),
                        array_map( function($unit) {
                            return clone $unit;
                        },$this->defenderUnits),
                        $this,
                        $this->logger
                    );
                    break;

                case self::SEA_BATTLE:
                    if($this->logger)
                        $this->logger->notice(
                            'New Sea Battle',
                            ['Iteration' => $i + 1, 'Total' => $this->settings->getAccuracy()]
                        );

                    $battle = new SeaBattle(
                        array_map( function($unit) {
                            return clone $unit;
                        }, $this->attackerUnits),
                        array_map( function($unit) {
                            return clone $unit;
                        },$this->defenderUnits),
                        $this,
                        $this->logger
                    );
                    break;

                default:
                    throw new \InvalidArgumentException();
                    break;
            }

            /** @var BattleResult $result */
            $result = $battle->getResult();

            $this->results[] = $result;
        }

        return $this->results;
    }

    /**
     * Deletes the battle.log.
     */
    private function clearLog()
    {
        $pathToLog = '..\\app\\logs\\battle.log';
        if (file_exists($pathToLog)) {
            unlink ($pathToLog);
        }

    }

    /**
     * @return Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @return array
     */
    public function getTechnologies()
    {
        return $this->technologies;
    }

}
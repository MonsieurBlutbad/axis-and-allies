<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 23.10.2015
 * Time: 14:09
 */

namespace AppBundle\BattleCalculator;

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
     * @var Settings
     */
    private $settings;

    /**
     * @var Result[]
     */
    private $results = [];

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param $data
     * @param Logger $logger
     */
    function __construct($data, Logger $logger = null)
    {
        $extractedUnits = $this->getUnitsFromData($data);
        $this->attackerUnits = $extractedUnits[0];
        $this->defenderUnits = $extractedUnits[1];

        $this->settings = new Settings( intval($data['accuracy']), true );

        $this->type = $data['type'];
        if(! in_array($this->type, [self::LAND_BATTLE, self::AMPHIBIOUS_ASSAULT, self::SEA_BATTLE]))
            throw new \InvalidArgumentException();

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
     * @return Result[]
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
                        $this->logger
                    );
                    break;

                default:
                    throw new \InvalidArgumentException();
                    break;
            }

            /** @var Result $result */
            $result = $battle->getResult();

            $this->results[] = $result;
        }

        return $this->results;
    }


    /**
     * Extracts units from the submitted form data.
     *
     * @param $data
     * @return array
     */
    private function getUnitsFromData($data) {
        $attackingUnits = [];
        $defendingUnits = [];
        foreach($data as $inputField => $inputValue) {
            if(is_numeric($inputValue) && $inputValue > 0) {
                if(preg_match('/^.*(attacker_)(\w+)$/', $inputField, $matches)) {
                    $name = $matches[2];
                    for($i = 0; $i < $inputValue; $i++)
                        $attackingUnits[] = $this->getUnitFromName($name);
                }
                elseif(preg_match('/^.*(defender_)(\w+)$/', $inputField, $matches)) {
                    $name = $matches[2];
                    for($i = 0; $i < $inputValue; $i++)
                        $defendingUnits[] = $this->getUnitFromName($name);
                }
            }
        }
        return [$attackingUnits, $defendingUnits];
    }

    /**
     * @param $name
     * @return AircraftCarrier|Battleship|Cruiser
     */
    private function getUnitFromName($name)
    {
        switch($name) {
            case 'infantry':
                return new Infantry($this->logger);
                break;
            case 'artillery':
                return new Artillery($this->logger);
                break;
            case 'mechanized_infantry':
                return new MechanizedInfantry($this->logger);
                break;
            case 'tank':
                return new Tank($this->logger);
                break;
            case 'antiaircraft_artillery':
                return new AntiaircraftArtillery($this->logger);
                break;
            case 'fighter':
                return new Fighter($this->logger);
                break;
            case 'tactical_bomber':
                return new TacticalBomber($this->logger);
                break;
            case 'strategic_bomber':
                return new StrategicBomber($this->logger);
                break;
            case 'transport':
                return new Transport($this->logger);
                break;
            case 'submarine':
                return new Submarine($this->logger);
                break;
            case 'destroyer':
                return new Destroyer($this->logger);
                break;
            case 'cruiser':
                return new Cruiser($this->logger);
                break;
            case 'aircraft_carrier':
                return new AircraftCarrier($this->logger);
                break;
            case 'battleship':
                return new Battleship($this->logger);
                break;
            default:
                throw new \InvalidArgumentException();
                break;
        }
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

}
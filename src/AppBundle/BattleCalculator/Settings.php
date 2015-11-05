<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 23.10.2015
 * Time: 15:28
 */

namespace AppBundle\BattleCalculator;


class Settings {

    const ACCURACY_DEBUG   = 10;
    const ACCURACY_FAST    = 1000;
    const ACCURACY_GOOD    = 2000;
    const ACCURACY_EXTREME = 5000;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var int
     */
    private $accuracy;

    /**
     * @var boolean
     */
    private $mustTakeTerritory;

    // TODO: Keep Destroyers while subs are alive
    function __construct($accuracy = self::ACCURACY_DEBUG, $debug = false)
    {
        $this->accuracy = $accuracy;
        $this->debug = $debug;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @return int
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
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

}
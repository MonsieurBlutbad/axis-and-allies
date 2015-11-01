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

    private $debug;

    private $accuracy;

    // TODO: Must take territory (prioritize last land unit over air units)
    // TODO: Keep Destroyers while subs are alive

    function __construct($accuracy = self::ACCURACY_DEBUG, $debug = false)
    {
        $this->accuracy = $accuracy;
        $this->debug = $debug;
    }

    /**
     * @return mixed
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @return mixed
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * @param mixed $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @param mixed $accuracy
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    }

}
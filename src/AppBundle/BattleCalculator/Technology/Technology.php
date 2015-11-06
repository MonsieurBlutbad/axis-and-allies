<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 24.10.2015
 * Time: 10:54
 */

namespace AppBundle\BattleCalculator\Technology;

abstract class Technology
{
    const NAME = '';

    /**
     * @var integer
     */
    protected static $attack = null;

    /**
     * @var array
     */
    protected static $tags = null;

    abstract function getImproves();

    /**
     * @return int
     */
    public static function getAttack()
    {
        return static::$attack;
    }

    /**
     * @return array
     */
    public static function getTags()
    {
        return static::$tags;
    }

    /**
     * @param $tag
     * @return bool
     */
    public static function hasTag($tag) {
        return in_array($tag, static::$tags, true);
    }

}
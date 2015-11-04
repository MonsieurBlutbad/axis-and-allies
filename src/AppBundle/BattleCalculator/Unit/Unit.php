<?php

namespace AppBundle\BattleCalculator\Unit;

use AppBundle\BattleCalculator\CombinedArms\CombinedArms;
use AppBundle\BattleCalculator\Side;
use Symfony\Bridge\Monolog\Logger;

/**
 * Unit
 */
abstract class Unit
{
    // TODO outsource to tag class
    const AIR_DEFENSE                     = 'air_defense';
    const CHOSEN_LAST                     = 'chosen_last';
    const SURPRISE_STRIKE                 = 'surprise_strike';
    const CANT_HIT_AIR_UNITS              = 'cant_hit_air_units';
    const CANT_BE_HIT_BY_AIR_UNITS        = 'cant_be_hit_by_air_units';
    const DENIES_CANT_BE_HIT_BY_AIR_UNITS = 'denies_cant_be_hit_by_air_units';
    const CANT_ATTACK                     = 'cant_attack';
    const DENIES_SURPRISE_STRIKE          = 'denies_surprise_strike';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var integer
     */
    protected $cost = 0;

    /**
     * @var integer
     */
    protected $attack = 0;

    /**
     * @var integer
     */
    protected $defense = 0;

    /**
     * @var integer
     */
    protected $hitPoints = 1;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @var array
     */
    protected $combinations = [];

    /**
     * @var Unit
     */
    protected $combinedWith  = null;

    /**
     * @var bool
     */
    protected $hasShot = false;

    /**
     * @var Side
     */
    protected $side;

    /**
     * @var Logger
     */
    protected $logger;

    function __construct(Logger $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * Set attack
     *
     * @param integer $attack
     * @return Unit
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * Get attack
     *
     * @return integer 
     */
    public function getAttack()
    {
        if($this->combinedWith && isset($this->combinations[get_class($this->combinedWith)])) {
            /** @var CombinedArms $combination */
            $combination =  $this->combinations[get_class($this->combinedWith)];
            if($combination::getAttack() !== null) {
                return $combination::getAttack();
            }
        }

        return $this->attack;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     * @return Unit
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense
     *
     * @return integer 
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set hitPoints
     *
     * @param integer $hitPoints
     * @return Unit
     */
    public function setHitPoints($hitPoints)
    {
        $this->hitPoints = $hitPoints;

        return $this;
    }

    /**
     * Get hitPoints
     *
     * @return integer 
     */
    public function getHitPoints()
    {
        return $this->hitPoints;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        if($this->combinedWith && isset($this->combinations[get_class($this->combinedWith)])) {
            /** @var CombinedArms $combination */
            $combination =  $this->combinations[get_class($this->combinedWith)];
            if($combination::getTags() !== null) {
                return $combination::getTags();
            }
        }

        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param $tag
     */
    public function addTag($tag)
    {
        if(! in_array($tag, $this->tags, true))
            array_push($this->tags, $tag);
    }

    /**
     * @param $tag
     */
    public function removeTag($tag)
    {
        if(in_array($tag, $this->tags, true))
            unset($this->tags[array_search($tag, $this->tags, true)]);
    }

    /**
     * @param $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        if($this->combinedWith && isset($this->combinations[get_class($this->combinedWith)])) {
            /** @var CombinedArms $combination */
            $combination =  $this->combinations[get_class($this->combinedWith)];
            if($combination::getTags() !== null) {
                return $combination::hasTag($tag);
            }
        }

        return in_array($tag, $this->tags, true);
    }

    /**
     * @return array
     */
    public function getCombinations()
    {
        return $this->combinations;
    }

    /**
     * @param array $combinations
     */
    public function setCombinations($combinations)
    {
        $this->combinations = $combinations;
    }

    /**
     * @param $combination
     */
    public function addCombination($combination)
    {
        if(! in_array($combination, $this->combinations, true))
            array_push($this->combinations, $combination);
    }

    /**
     * @param $combination
     */
    public function removeCombination($combination)
    {
        if(in_array($combination, $this->combinations, true))
            unset($this->combinations[array_search($combination, $this->combinations, true)]);
    }

    /**
     * @param $combination
     * @return bool
     */
    public function hasCombination($combination)
    {
        return in_array($combination, $this->combinations, true);
    }

    /**
     * @return Unit
     */
    public function getCombinedWith()
    {
        if($this->combinedWith)
            return $this->combinedWith;
    }

    /**
     * @param Unit $combinedWith
     */
    public function setCombinedWith($combinedWith)
    {
        $this->combinedWith = $combinedWith;
    }

    /**
     * Subtracts a hitpoint.
     */
    public function applyHit()
    {
        $this->hitPoints --;

        if($this->logger)
            $this->logger->info('Applied hit', [$this->getName(), 'hitPoints' => $this->hitPoints, 'dead' => $this->isDead(), spl_object_hash($this) ]);
    }

    /**
     * @return bool
     */
    public function isDead()
    {
        return $this->hitPoints <= 0;
    }

    /**
     * @return Side
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @param Side $side
     */
    public function setSide($side)
    {
        $this->side = $side;
    }

    /**
     * @return boolean
     */
    public function getHasShot()
    {
        return $this->hasShot;
    }

    /**
     * @param boolean $hasShot
     */
    public function setHasShot($hasShot)
    {
        $this->hasShot = $hasShot;
    }

}

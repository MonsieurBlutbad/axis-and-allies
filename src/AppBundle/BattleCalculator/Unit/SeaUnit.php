<?php

namespace AppBundle\BattleCalculator\Unit;

/**
 * SeaUnit
 */
abstract class SeaUnit extends Unit
{
    /**
     * @var integer
     */
    protected $coastalBombardment;

    /**
     * @return int
     */
    public function getCoastalBombardment()
    {
        return $this->coastalBombardment;
    }

    /**
     * @param int $coastalBombardment
     */
    public function setCoastalBombardment($coastalBombardment)
    {
        $this->coastalBombardment = $coastalBombardment;
    }

}

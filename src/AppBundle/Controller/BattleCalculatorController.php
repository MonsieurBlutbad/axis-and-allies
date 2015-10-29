<?php

namespace AppBundle\Controller;

use AppBundle\BattleCalculator\Calculation;
use AppBundle\BattleCalculator\Calculator;
use AppBundle\BattleCalculator\Form\BattleForm;
use AppBundle\BattleCalculator\Form\Type\BattleFormType;
use AppBundle\BattleCalculator\BattleResult;
use AppBundle\BattleCalculator\Settings;
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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class BattleCalculatorController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index2Action(Request $request)
    {
        /** @var BattleForm $battleCalculatorForm */
        $battleCalculatorForm = new BattleForm();

        /** @var Form $form */
        $form = $this->createForm(new BattleFormType(), $battleCalculatorForm);

        $form->handleRequest($request);

        if($form->isValid())
            $result = $this->getResult($battleCalculatorForm);

        return $this->render(
            'AppBundle:BattleCalculator:index2.html.twig',
            [
                'form' => $form->createView(),
                'result' => isset($result)? $result : null,
            ]
        );
    }

    /**
     * Calculates the outcome of a submitted land battle.
     *
     * @param $data
     * @return Calculation
     */
    private function getResult($data)
    {
        /** @var Calculator $battleCalculator */
        $battleCalculator = new Calculator(
            $data,
            $this->container->get( 'kernel' )->getEnvironment() === 'dev'
                ? $this->get('monolog.logger.battle_calculator')
                : null
        );

        /** @var BattleResult[] $results */
       $results = $battleCalculator->getResults();

        /** @var Calculation $result */
        $result = new Calculation($results);

        return $result;
    }

}

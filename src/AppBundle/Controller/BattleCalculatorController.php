<?php

namespace AppBundle\Controller;

use AppBundle\BattleCalculator\Calculation;
use AppBundle\BattleCalculator\Calculator;
use AppBundle\BattleCalculator\Form\BattleForm;
use AppBundle\BattleCalculator\Form\Type\BattleFormType;
use AppBundle\BattleCalculator\BattleResult;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class BattleCalculatorController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
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

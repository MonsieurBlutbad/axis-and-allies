<?php

namespace AppBundle\Controller;

use AppBundle\BattleCalculator\Calculation;
use AppBundle\BattleCalculator\Calculator;
use AppBundle\BattleCalculator\Form\BattleForm;
use AppBundle\BattleCalculator\Result;
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
use Symfony\Component\HttpFoundation\Request;

class BattleCalculatorController extends Controller
{
    /**
     * @param Request $request
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $active = null) {
        // TODO: create form classes and types
        $landBattle = new BattleForm(Calculator::LAND_BATTLE);
        $landBattle->setForm($this->getLandBattleForm($landBattle->getData()));

        $amphibiousAssault = new BattleForm(Calculator::AMPHIBIOUS_ASSAULT);
        $amphibiousAssault->setForm($this->getAmphibiousAssaultForm($amphibiousAssault->getData()));

        $seaBattle = new BattleForm(Calculator::SEA_BATTLE);
        $seaBattle->setForm($this->getSeaBattleForm($seaBattle->getData()));

        $forms = [$landBattle, $amphibiousAssault, $seaBattle];

        foreach($forms as $form) {
            /** @var BattleForm $form */
            if($request->request->has($form->getType()))
                $form->getForm()->handleRequest($request);

            if ($form->getForm()->isValid()) {
                $form->setData($form->getForm()->getData());
                $form->setResult($this->getResult($form->getData()));
            }

            $form->setFormView($form->getForm()->createView());

        }



        return $this->render(
            'AppBundle:BattleCalculator:index.html.twig',
            [
                'landBattle'        => $landBattle,
                'amphibiousAssault' => $amphibiousAssault,
                'seaBattle'         => $seaBattle
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

        /** @var Result[] $results */
       $results = $battleCalculator->getResults();

        /** @var Calculation $result */
        $result = new Calculation($results);

        return $result;
    }

    /**
     * Returns the form for land battles.
     *
     * @param $dataObject
     * @return \Symfony\Component\Form\Form
     */
    private function getLandBattleForm($dataObject)
    {
        $attackUnitPool  = [
            new Infantry(),
            new MechanizedInfantry(),
            new Artillery(),
            new Tank(),
            new Fighter(),
            new TacticalBomber(),
            new StrategicBomber()
        ];
        $defenseUnitPool = [
            new Infantry(),
            new MechanizedInfantry(),
            new Artillery(),
            new Tank(),
            new AntiaircraftArtillery(),
            new Fighter(),
            new TacticalBomber(),
            new StrategicBomber()
        ];
        $formBuilder = $this->get('form.factory')->createNamedBuilder('land_battle', 'form', $dataObject);
        $formBuilder->add( 'type', 'hidden', ['data' => 'land_battle']);
        $formBuilder->add( 'accuracy', 'choice', [
            'choices' => [
                Settings::ACCURACY_DEBUG => 'Debug',
                Settings::ACCURACY_FAST => 'Fast',
                Settings::ACCURACY_GOOD => 'Accurate',
                Settings::ACCURACY_EXTREME => 'Extreme'
            ],
            'label' => 'Accuracy',
            'required' => true,
            'data' => Settings::ACCURACY_DEBUG
        ]);
        foreach($attackUnitPool as $unit)
            /** @var Unit $unit */
            $formBuilder->add( 'attacker_' . $unit->getName(), 'number',
                [
                    'label' => $unit->getName(),
                    'required' => false,
                    'attr' => ['placeholder' => 0],
                    'translation_domain' => 'land_battle'
                ]);
        foreach($defenseUnitPool as $unit)
            $formBuilder->add( 'defender_' . $unit->getName(), 'number',
                [
                    'label' => $unit->getName(),
                    'required' => false,
                    'attr' => ['placeholder' => 0],
                    'translation_domain' => 'land_battle'
                ]);
        $formBuilder->add( 'calculate', 'submit', ['label' => 'Calculate']);

        return $formBuilder->getForm();
    }

    /**
     * Returns the form for Amphibious Assaults.
     *
     * @param $dataObject
     * @return \Symfony\Component\Form\Form
     */
    private function getAmphibiousAssaultForm($dataObject)
    {
        $attackUnitPool  = [
            new Infantry(),
            new MechanizedInfantry(),
            new Artillery(),
            new Tank(),
            new Fighter(),
            new TacticalBomber(),
            new StrategicBomber(),
            new Cruiser(),
            new Battleship(),
        ];
        $defenseUnitPool = [
            new Infantry(),
            new MechanizedInfantry(),
            new Artillery(),
            new Tank(),
            new AntiaircraftArtillery(),
            new Fighter(),
            new TacticalBomber(),
            new StrategicBomber()
        ];
        $formBuilder = $this->get('form.factory')->createNamedBuilder('amphibious_assault', 'form', $dataObject);
        $formBuilder->add( 'type', 'hidden', ['data' => 'amphibious_assault']);
        $formBuilder->add( 'accuracy', 'choice', [
            'choices' => [
                Settings::ACCURACY_DEBUG => 'Debug',
                Settings::ACCURACY_FAST => 'Fast',
                Settings::ACCURACY_GOOD => 'Accurate',
                Settings::ACCURACY_EXTREME => 'Extreme'
            ],
            'label' => 'Accuracy',
            'required' => true,
            'data' => Settings::ACCURACY_DEBUG
        ]);
        foreach($attackUnitPool as $unit)
            /** @var Unit $unit */
            $formBuilder->add( 'attacker_' . $unit->getName(), 'number',
                [
                    'label' => $unit->getName(),
                    'required' => false,
                    'attr' => ['placeholder' => 0],
                    'translation_domain' => 'amphibious_assault'
                ]);
        foreach($defenseUnitPool as $unit)
            $formBuilder->add( 'defender_' . $unit->getName(), 'number',
                [
                    'label' => $unit->getName(),
                    'required' => false,
                    'attr' => ['placeholder' => 0],
                    'translation_domain' => 'amphibious_assault'
                ]);
        $formBuilder->add( 'calculate', 'submit', ['label' => 'Calculate']);

        return $formBuilder->getForm();
    }

    /**
     * Returns the form for sea battles.
     *
     * @param $dataObject
     * @return \Symfony\Component\Form\Form
     */
    private function getSeaBattleForm($dataObject)
    {
        $attackUnitPool  = [
            new Submarine(),
            new Destroyer(),
            new Cruiser(),
            new AircraftCarrier(),
            new Battleship(),
            new Fighter(),
            new TacticalBomber(),
            new StrategicBomber(),
            new Transport(),
        ];
        $defenseUnitPool = [
            new Submarine(),
            new Destroyer(),
            new Cruiser(),
            new AircraftCarrier(),
            new Battleship(),
            new Fighter(),
            new TacticalBomber(),
            new StrategicBomber(),
            new Transport(),
        ];
        $formBuilder =  $this->get('form.factory')->createNamedBuilder('sea_battle', 'form', $dataObject);
        $formBuilder->add( 'type', 'hidden', ['data' => 'sea_battle']);
        $formBuilder->add( 'accuracy', 'choice', [
            'choices' => [
                Settings::ACCURACY_DEBUG => 'Debug',
                Settings::ACCURACY_FAST => 'Fast',
                Settings::ACCURACY_GOOD => 'Accurate',
                Settings::ACCURACY_EXTREME => 'Extreme'
            ],
            'label' => 'Accuracy',
            'required' => true,
            'data' => Settings::ACCURACY_DEBUG
        ]);
        foreach($attackUnitPool as $unit)
            /** @var Unit $unit */
            $formBuilder->add( 'attacker_' . $unit->getName(), 'number',
                [
                    'label' => $unit->getName(),
                    'required' => false,
                    'attr' => ['placeholder' => 0],
                    'translation_domain' => 'sea_battle'
                ]);
        foreach($defenseUnitPool as $unit)
            $formBuilder->add( 'defender_' . $unit->getName(), 'number',
                [
                    'label' => $unit->getName(),
                    'required' => false,
                    'attr' => ['placeholder' => 0],
                    'translation_domain' => 'sea_battle'
                ]);
        $formBuilder->add( 'calculate', 'submit', ['label' => 'Calculate']);

        return $formBuilder->getForm();
    }

}

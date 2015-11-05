<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 28.10.2015
 * Time: 21:20
 */

namespace AppBundle\BattleCalculator\Form\Type;

use AppBundle\BattleCalculator\Calculator;
use AppBundle\BattleCalculator\Form\BattleForm;
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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BattleFormType extends AbstractType
{
    protected $attackerUnits = [
        'Infantry' => Infantry::class,
        'Mechanized Infantry' => MechanizedInfantry::class,
        'Artillery' => Artillery::class,
        'Tank' => Tank::class,
        'Fighter' => Fighter::class,
        'Tactical Bomber' => TacticalBomber::class,
        'Strategic Bomber' => StrategicBomber::class,
        'Transport' => Transport::class,
        'Submarine' => Submarine::class,
        'Destroyer' => Destroyer::class,
        'Cruiser' => Cruiser::class,
        'Aircraft Carrier' => AircraftCarrier::class,
        'Battleship' => Battleship::class,
    ];

    protected $defenderUnits = [
        'Infantry' => Infantry::class,
        'Mechanized Infantry' => MechanizedInfantry::class,
        'Artillery' => Artillery::class,
        'Tank' => Tank::class,
        'Antiaircraft Artillery' => AntiaircraftArtillery::class,
        'Fighter' => Fighter::class,
        'Tactical Bomber' => TacticalBomber::class,
        'Strategic Bomber' => StrategicBomber::class,
        'Transport' => Transport::class,
        'Submarine' => Submarine::class,
        'Destroyer' => Destroyer::class,
        'Cruiser' => Cruiser::class,
        'Aircraft Carrier' => AircraftCarrier::class,
        'Battleship' => Battleship::class,
    ];

    /**
     * @param FormBuilderInterface $builder
     */
    protected function addSettings(FormBuilderInterface $builder)
    {
        $builder
            ->add('accuracy', 'hidden', [
                'data' => Settings::ACCURACY_GOOD
            ])
            ->add('type', 'choice', [
                'choices' => [
                    Calculator::LAND_BATTLE => 'Land Battle',
                    Calculator::AMPHIBIOUS_ASSAULT => 'Amphibious Assault',
                    Calculator::SEA_BATTLE => 'Sea Battle',
                ],
                'attr' => [
                    'class' => 'form-control '
                ],
                'label' => 'Type',
                'required' => true,
                'data' => Calculator::LAND_BATTLE
            ])
            ->add('mustTakeTerritory', 'checkbox', [
                'label' => 'Must Take Territory',
                'required' => false,
                'attr' => [
                    'class' => 'form-control ' . Calculator::LAND_BATTLE . ' ' . Calculator::AMPHIBIOUS_ASSAULT,
                ],
                'label_attr' => [
                    'data-toggle' => 'tooltip',
                    'title' => 'Attacker must keep at least one land unit alive',
                    'data-placement' => 'top'
                ]
            ])
            ->add('keepDestroyers', 'checkbox', [
                'label' => 'Keep Destroyers while enemy has subs',
                'required' => false,
                'attr' => [
                    'class' => 'form-control ' . Calculator::SEA_BATTLE,
                ],
                'label_attr' => [
                    'data-toggle' => 'tooltip',
                    'title' => 'Will not take the last Destroyer as casualty when the enemy has still subs in the battle',
                    'data-placement' => 'top'
                ]
            ])
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function addUnits(FormBuilderInterface $builder)
    {
        foreach($this->attackerUnits as $label => $unit) {
            $builder->add('attacker_' . $unit::NAME, 'number', [
                'label' => $label,
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        ($unit::LAND_BATTLE ? Calculator::LAND_BATTLE . ' ' : '') .
                        ($unit::AMPHIBIOUS_ASSAULT ? Calculator::AMPHIBIOUS_ASSAULT . ' ' : '') .
                        ($unit::SEA_BATTLE ? Calculator::SEA_BATTLE . ' ' : ''),
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                    'data-cost' => $unit::COST,
                    'data-battle-value' => $unit::ATTACK,
                    'data-name' => $unit::NAME,
                    'data-hit-points' => $unit::HIT_POINTS,
                ]

            ]);
        }
        foreach($this->defenderUnits as $label => $unit) {
            $builder->add('defender_' . $unit::NAME, 'number', [
                'label' => $label,
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        ($unit::LAND_BATTLE ? Calculator::LAND_BATTLE . ' ' . Calculator::AMPHIBIOUS_ASSAULT . ' ' : '') .
                        ($unit::SEA_BATTLE ? Calculator::SEA_BATTLE . ' ' : ''),
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                    'data-cost' => $unit::COST,
                    'data-battle-value' => $unit::DEFENSE,
                    'data-name' => $unit::NAME,
                    'data-hit-points' => $unit::HIT_POINTS,
                ]

            ]);
        }
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function addAttackerTechnologies(FormBuilderInterface $builder)
    {

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addSettings($builder);
        $this->addUnits($builder);

        $builder->add('Calculate', 'submit');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'battle_form';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\BattleCalculator\Form\BattleForm',
        ));
    }
}
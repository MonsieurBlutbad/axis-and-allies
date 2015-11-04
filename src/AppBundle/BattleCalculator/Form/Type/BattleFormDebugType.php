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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BattleFormDebugType extends BattleFormType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('accuracy', 'choice', [
                'choices' => [
                    Settings::ACCURACY_DEBUG => 'Debug',
                    Settings::ACCURACY_FAST => 'Fast',
                    Settings::ACCURACY_GOOD => 'Accurate',
                    Settings::ACCURACY_EXTREME => 'Extreme'
                ],
                'attr' => [
                    'class' => 'form-control '
                ],
                'label' => 'Accuracy',
                'required' => true,
                'data' => Settings::ACCURACY_DEBUG
                ])
        ;
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
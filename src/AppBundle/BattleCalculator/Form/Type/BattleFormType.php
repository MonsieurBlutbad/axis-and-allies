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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BattleFormType extends AbstractType
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
            ->add('attacker_infantry', 'number', [
                'label' => 'Infantry',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT ,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_mechanized_infantry', 'number', [
                'label' => 'Mechanized Infantry',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_artillery', 'number', [
                'label' => 'Artillery',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_tank', 'number', [
                'label' => 'Tank',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_fighter', 'number', [
                'label' => 'Fighter',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT. ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_tactical_bomber', 'number', [
                'label' => 'Tactical Bomber',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT. ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_strategic_bomber', 'number', [
                'label' => 'Strategic Bomber',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT. ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_transport', 'number', [
                'label' => 'Transport',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_submarine', 'number', [
                'label' => 'Submarine',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_destroyer', 'number', [
                'label' => 'Destroyer',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_cruiser', 'number', [
                'label' => 'Cruiser',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::AMPHIBIOUS_ASSAULT . ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_aircraft_carrier', 'number', [
                'label' => 'Aircraft Carrier',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('attacker_battleship', 'number', [
                'label' => 'Battleship',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::AMPHIBIOUS_ASSAULT . ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])

            ->add('defender_infantry', 'number', [
                'label' => 'Infantry',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT ,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_mechanized_infantry', 'number', [
                'label' => 'Mechanized Infantry',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_artillery', 'number', [
                'label' => 'Artillery',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_tank', 'number', [
                'label' => 'Tank',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_antiaircraft_artillery', 'number', [
                'label' => 'Antiaircraft Artillery',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_fighter', 'number', [
                'label' => 'Fighter',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT. ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_tactical_bomber', 'number', [
                'label' => 'Tactical Bomber',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT. ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_strategic_bomber', 'number', [
                'label' => 'Strategic Bomber',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::LAND_BATTLE . ' ' .
                        Calculator::AMPHIBIOUS_ASSAULT. ' ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_transport', 'number', [
                'label' => 'Transport',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_submarine', 'number', [
                'label' => 'Submarine',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_destroyer', 'number', [
                'label' => 'Destroyer',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_cruiser', 'number', [
                'label' => 'Cruiser',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_aircraft_carrier', 'number', [
                'label' => 'Aircraft Carrier',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])
            ->add('defender_battleship', 'number', [
                'label' => 'Battleship',
                'required' => false,
                'attr' => [
                    'class' =>
                        'form-control ' .
                        Calculator::SEA_BATTLE,
                    'placeholder' => 0,
                    'min' => 0,
                    'max' => 999,
                ]
            ])

            ->add('Calculate', 'submit')
        ;
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
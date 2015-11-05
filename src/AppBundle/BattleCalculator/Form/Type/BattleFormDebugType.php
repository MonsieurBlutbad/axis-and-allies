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
     */
    protected function addSettings(FormBuilderInterface $builder)
    {
        parent::addSettings($builder);

        $builder
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

    }
}
<?php
/**
 * <Kurzbeschreibung>
 * 
 * @author:     BK
 * @copyright:  2015 WEFRA Werbeagentur Frankfurt GmbH
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RulesController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $active = 'content';

        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules:', 'content', 'content')
        ];

        return $this->render(
            'AppBundle:Rules:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    /**
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function houseRulesAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules\HouseRules:', 'victory_objectives', $active)
        ];

        return $this->render(
            'AppBundle:Rules\HouseRules:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    /**
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generalAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules\General:', 'victory_conditions', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\General:', 'order_of_play', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\General:', 'starting_income', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\General:', 'turn_sequence', $active),
        ];

        return $this->render(
            'AppBundle:Rules\General:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    /**
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function powerAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'germany', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'soviet_union', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'japan', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'united_states', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'china', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'united_kingdom', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'italy', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'anzac', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'france', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'dutch_territories', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Power:', 'neutral_territories', $active),
        ];

        return $this->render(
            'AppBundle:Rules\Power:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    /**
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function terrainAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules\Terrain:', 'territories', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Terrain:', 'sea_zones', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Terrain:', 'islands', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Terrain:', 'canals_and_narrow_straits', $active),

        ];

        return $this->render(
            'AppBundle:Rules\Terrain:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    /**
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function turnAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'research_and_development', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'repair_damaged_units', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'purchase_new_units', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'combat_movement', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'conduct_combat', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'non_combat_movement', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'mobilize_new_units', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Turn:', 'collect_income', $active),
        ];
        return $this->render(
            'AppBundle:Rules\Turn:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    /**
     * @param null $active
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function unitAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Rules\Unit:', 'facilities', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Unit:', 'land_units', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Unit:', 'air_units', $active),
            $templateRenderer->createSection( 'AppBundle:Rules\Unit:', 'sea_units', $active)
        ];
        return $this->render(
            'AppBundle:Rules\Unit:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

}
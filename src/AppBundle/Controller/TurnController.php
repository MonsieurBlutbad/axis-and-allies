<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TurnController extends Controller
{

    public function indexAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Turn:', 'research_and_development', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'repair_damaged_units', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'purchase_new_units', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'combat_movement', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'conduct_combat', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'non_combat_movement', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'mobilize_new_units', $active),
            $templateRenderer->createSection( 'AppBundle:Turn:', 'collect_income', $active),
        ];
        return $this->render(
            'AppBundle:Turn:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }
}

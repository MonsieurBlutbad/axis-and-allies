<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GeneralController extends Controller
{

    public function indexAction($active = null) {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:General:', 'victory_conditions', $active),
            $templateRenderer->createSection( 'AppBundle:General:', 'order_of_play', $active),
            $templateRenderer->createSection( 'AppBundle:General:', 'starting_income', $active),
            $templateRenderer->createSection( 'AppBundle:General:', 'turn_sequence', $active),
        ];

        return $this->render(
            'AppBundle:General:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

}

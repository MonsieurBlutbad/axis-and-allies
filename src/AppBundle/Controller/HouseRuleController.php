<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HouseRuleController extends Controller
{

    public function indexAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:HouseRules:', 'victory_objectives', $active)
        ];

        return $this->render(
            'AppBundle:HouseRules:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }
}

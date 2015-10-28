<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UnitController extends Controller
{

    public function indexAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

         $sections = [
             $templateRenderer->createSection( 'AppBundle:Unit:', 'facilities', $active),
             $templateRenderer->createSection( 'AppBundle:Unit:', 'land_units', $active),
             $templateRenderer->createSection( 'AppBundle:Unit:', 'air_units', $active),
             $templateRenderer->createSection( 'AppBundle:Unit:', 'sea_units', $active)
        ];
        return $this->render(
            'AppBundle:Unit:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }
}

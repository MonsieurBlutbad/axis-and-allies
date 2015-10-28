<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TerrainController extends Controller
{

    public function indexAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Terrain:', 'territories', $active),
            $templateRenderer->createSection( 'AppBundle:Terrain:', 'sea_zones', $active),
            $templateRenderer->createSection( 'AppBundle:Terrain:', 'islands', $active),
            $templateRenderer->createSection( 'AppBundle:Terrain:', 'canals_and_narrow_straits', $active),

        ];

        return $this->render(
            'AppBundle:Terrain:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

}

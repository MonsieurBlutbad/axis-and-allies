<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PowerController extends Controller
{

    public function indexAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Power:', 'germany', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'soviet_union', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'japan', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'united_states', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'china', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'united_kingdom', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'italy', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'anzac', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'france', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'dutch_territories', $active),
            $templateRenderer->createSection( 'AppBundle:Power:', 'neutral_territories', $active),
        ];

        return $this->render(
            'AppBundle:Power:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }
}

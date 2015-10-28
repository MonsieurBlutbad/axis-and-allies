<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    public function downloadsAction($active = null)
    {

        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Downloads:', 'rule_books', $active),
        ];

        return $this->render(
            'AppBundle:Downloads:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }

    public function linksAction($active = null)
    {
        $templateRenderer = $this->container->get('app.template_renderer');

        $sections = [
            $templateRenderer->createSection( 'AppBundle:Links:', 'forums', $active),
            $templateRenderer->createSection( 'AppBundle:Links:', 'triple_a', $active),
            $templateRenderer->createSection( 'AppBundle:Links:', 'youtube', $active),
        ];

        return $this->render(
            'AppBundle:Links:index.html.twig',
            [ 'sections' => $templateRenderer->getSections($sections) ]
        );
    }
}

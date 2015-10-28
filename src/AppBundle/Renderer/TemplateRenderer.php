<?php

namespace AppBundle\Renderer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemplateRenderer extends Controller
{
    /** @var  \Twig_Environment $twig */
    private $twig;

    function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function getSections($sections) {
        $panels = [];
        foreach($sections as $section) {
            $template = $this->twig->loadTemplate($section['template']);
            $panels[] = [
                'id' => $section['id'],
                'title' => $template->renderBlock('title', []),
                'body' => $template->renderBlock('body', []),
                'active' => $section['active'],
            ];
        }
        return $panels;
    }

    public function createSection($templatePath, $id, $active) {
        return [
            'id' => $id,
            'template' => $templatePath . $id . '.html.twig',
            'active' => $id === $active
        ];
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController {
    public function home(\Twig_Environment $twig) {
        $content = $twig->render('base.html.twig');
        $response = new Response();
        $response->setContent($content);
        return $response;
    }
}
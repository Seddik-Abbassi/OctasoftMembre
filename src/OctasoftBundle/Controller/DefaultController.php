<?php

namespace OctasoftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OctasoftBundle:Default:index.html.twig');
    }
}

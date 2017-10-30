<?php

namespace Hristonev\SportMonks\Client\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HristonevSportMonksClientBundle:Default:index.html.twig');
    }
}

<?php

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlayerController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlayerBundle:Default:index.html.twig');
    }
}

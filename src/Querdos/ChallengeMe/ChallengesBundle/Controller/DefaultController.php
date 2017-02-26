<?php

namespace Querdos\ChallengeMe\ChallengesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChallengesBundle:Default:index.html.twig');
    }
}

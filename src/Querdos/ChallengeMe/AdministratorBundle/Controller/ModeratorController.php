<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ModeratorController extends Controller
{
    /**
     * @Template("AdminBundle:content:dashboard.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
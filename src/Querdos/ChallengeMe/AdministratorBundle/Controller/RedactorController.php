<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 11:14 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RedactorController extends Controller
{
    /**
     * @Template("AdminBundle:content:dashboard.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
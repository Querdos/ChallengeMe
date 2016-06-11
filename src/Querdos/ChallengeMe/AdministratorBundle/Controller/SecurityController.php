<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends Controller
{
    public function homepageAction()
    {
        $authChecker = $this->get('security.authorization_checker');

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_homepage');
        } else if (true === $authChecker->isGranted('ROLE_MODERATOR')) {
            return $this->redirectToRoute('moderator_homepage');
        } else if (true === $authChecker->isGranted('ROLE_REDACTOR')) {
            return $this->redirectToRoute('redactor_homepage');
        } else {
            return $this->redirectToRoute('admin_login');
        }
    }

    /**
     * @Template("AdminBundle:security:login.html.twig")
     *
     * @return  array
     */
    public function loginAdminAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error          = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername   = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Template("AdminBundle:security:login.html.twig")
     * @return array
     */
    public function loginModeratorAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error          = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername   = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Template("AdminBundle:security:login.html.twig")
     * 
     * @return array
     */
    public function loginRedactorAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error          = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername   = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * Check login method for admin
     */
    public function loginAdminCheckAction() {}

    public function loginModeratorCheckAction(){}

    public function loginRedactorCheckAction(){}

    /**
     * @param   Request         $request
     * @return  RedirectResponse
     */
    public function logoutAction(Request $request) {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->get('security.firewall.context')->setToken(null);
            $request->getSession()->invalidate();
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('admin_login');
        } else if (in_array('ROLE_MODERATOR', $user->getRoles())) {
            return $this->redirectToRoute('moderator_login');
        } else if (in_array('ROLE_REDACTOR', $user->getRoles())) {
            return $this->redirectToRoute('redactor_login');
        }
    }
}
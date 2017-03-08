<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\Moderator;
use Querdos\ChallengeMe\UserBundle\Entity\Redactor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{

    /**
     * Redirect the user to the login page or its homepage
     *
     * @return RedirectResponse
     */
    public function defaultAction()
    {
        $user = $this->getUser();

        // Checking Admin
        if ($user instanceof Administrator) {
            return $this->redirectToRoute('administration_homepage');
        }

        return $this->redirectToRoute('administration_login');
    }

    /**
     * @Template("AdminBundle:security:login.html.twig")
     *
     * @return  array | RedirectResponse
     */
    public function loginAction() {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            return $this->redirectToRoute('administration_homepage');
        }

        /** @var AuthenticationException $exception */
        $exception = $this->get('security.authentication_utils')
            ->getLastAuthenticationError();

        return [
            'error' => $exception ? $exception->getMessage() : NULL,
        ];
    }

    public function loginCheckAction() {}

    /**
     * @param   Request $request
     */
    public function logoutAction(Request $request) {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->get('security.firewall.context')->setToken(null);
            $request->getSession()->invalidate();
        }
    }
}
<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Security\Authenticator;

use Querdos\ChallengeMe\PlayerBundle\Security\Provider\PlayerProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\VarDumper\VarDumper;

class FormAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * @var string
     */
    private $failMessage = "Invalid credentials";

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() !== '/players/login_check') {
            return;
        }

        return array(
            'username'  => $request->request->get('_username'),
            'password'  => $request->request->get('_password')
        );
    }

    /**
     * {@inheritdoc}
     *
     * For the user provider, see security.yml
     *      - 0 => AdministratorProvider
     *      - 1 => PlayerProvider
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var PlayerProvider $playerProvider */
        $playerProvider = $userProvider->getProviders()[1];

        if (null !== $userLoaded = $playerProvider->loadUserByUsername($credentials['username']))
        {
            return $userLoaded;
        }

        throw new CustomUserMessageAuthenticationException("Invalid credentials");
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        /** @var PasswordEncoder $encoder */
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        if (true === $encoder->isPasswordValid($user->getPassword(), $credentials['password'], null)) {
            return true;
        }

        throw new CustomUserMessageAuthenticationException($this->failMessage);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // Setting the url for redirection
        $url = $this->router->generate('player_homepage');

        // Redirecting
        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // setting auth error
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        // generating url
        $url = $this->router->generate('player_login');
        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('player_login');
        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @param mixed $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }
}
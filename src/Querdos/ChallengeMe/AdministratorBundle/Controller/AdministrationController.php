<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Querdos\ChallengeMe\AdministratorBundle\Form\AdministratorType;
use Querdos\ChallengeMe\AdministratorBundle\Form\ModeratorType;
use Querdos\ChallengeMe\AdministratorBundle\Form\RedactorType;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdministrationController extends Controller
{
    /**
     * @Template("AdminBundle:content:dashboard.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        // retrieving managers
        $adminManager       = $this->get('challengeme.manager.administrator');
        $moderatorManager   = $this->get('challengeme.manager.moderator');
        $redacManager       = $this->get('challengeme.manager.redactor');

        return array(
            'adminCount'    => count($adminManager->all()),
            'modoCount'     => count($moderatorManager->all()),
            'redacCount'    => count($redacManager->all())
        );
    }

    /**
     * @Template("AdminBundle:content:inbox.html.twig")
     *
     * @return array
     */
    public function inboxAction()
    {
        return array();
    }

    /**
     * @Template("AdminBundle:content:profile.html.twig")
     *
     * @return array
     */
    public function profileAction()
    {
        return array();
    }

    /**
     * @Template("AdminBundle:content:players_management.html.twig")
     *
     * @return array
     */
    public function playersManagementAction() {
        return array();
    }

    /**
     * @Template("AdminBundle:content:admins_management.html.twig")
     *
     * @return array
     */
    public function adminsManagementAction() {
        /** @var AdministratorManager $adminManager */
        $adminManager = $this->get('challengeme.manager.administrator');

        return array(
            'administrators'    => $adminManager->all()
        );
    }

    /**
     * @Template("AdminBundle:content:add_admin.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function addAdminAction(Request $request)
    {
        $admin = new Administrator();
        $form  = $this->createForm(AdministratorType::class, $admin, array(
            'create'    => true
        ));

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            // Persisting the new administrator
            $this->get('challengeme.manager.administrator')->create($admin);

            // Redirecting after success
            return $this->redirectToRoute('administration_adminsManagement');
        }

        return array(
            'form'  => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content:update_admin.html.twig")
     *
     * @param $id
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateAdminAction($id, Request $request)
    {
        // Retrieving admin
        $admin = $this->get('challengeme.manager.administrator')->readById($id);
        
        // Building the form
        $form   = $this->createForm(AdministratorType::class, $admin, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            dump($admin);die;
            // Persisting the admin
            $this->get('challengeme.manager.administrator')->update($admin);
            
            // Redirecting to the admins management page
            return $this->redirectToRoute('administration_adminsManagement');
        }
        
        return array(
            'username' => $admin->getUsername(),
            'form'     => $form->createView()
        );
    }
    
    /**
     * Remove and admin from the database
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeAdminAction($id, Request $request)
    {
        // Checking authorization
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url        = $this->generateUrl('administration_adminsManagement');
        $referer    = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('administration_adminsManagement');
        }

        // Retrieving admin
        $admin = $this->get('challengeme.manager.administrator')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.administrator')->delete($admin);

        // Redirecting
        return $this->redirectToRoute('administration_adminsManagement');
    }

    /**
     * @Template("AdminBundle:content:moderators_management.html.twig")
     *
     * @return array
     */
    public function moderatorsManagementAction() {
        /** @var ModeratorManager $moderatorManager */
        $moderatorManager = $this->get('challengeme.manager.moderator');

        return array(
            'moderators' => $moderatorManager->all()
        );
    }

    /**
     * @Template("AdminBundle:content:add_moderator.html.twig")
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function addModeratorAction(Request $request)
    {
        $moderator  = new Moderator();
        $form   = $this->createForm(ModeratorType::class, $moderator);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            // Persisting the new administrator
            $this->get('challengeme.manager.moderator')->create($moderator);

            // Redirecting after success
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        return array(
            'form'  => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content:update_moderator.html.twig")
     *
     * @param $id
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateModeratorAction($id, Request $request)
    {
        // 
    }
    
    /**
     * Remove a moderator from database
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeModeratorAction($id, Request $request)
    {
        // Checking authorization
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url        = $this->generateUrl('administration_moderatorsManagement');
        $referer    = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        // Retrieving admin
        $moderator = $this->get('challengeme.manager.moderator')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.moderator')->delete($moderator);

        // Redirecting
        return $this->redirectToRoute('administration_moderatorsManagement');
    }

    /**
     * @Template("AdminBundle:content:redactors_management.html.twig")
     *
     * @return array
     */
    public function redactorsManagementAction() {
        /** @var RedactorManager $redactorManager */
        $redactorManager = $this->get('challengeme.manager.redactor');

        return array(
            'redactors' => $redactorManager->all()
        );
    }

    /**
     * @Template("AdminBundle:content:add_redactor.html.twig")
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function addRedactorAction(Request $request)
    {
        $redactor = new Redactor();
        $form     = $this->createForm(RedactorType::class, $redactor);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            // Persisting the new redactor
            $this->get('challengeme.manager.redactor')->create($redactor);

            // Redirecting after success
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        return array(
            'form'  => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content:update_redactor.html.twig")
     *
     * @param $id
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateRedactorAction($id, Request $request)
    {
        
    }
    
    /**
     * Remove a redactor from database
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeRedactorAction($id, Request $request)
    {
        // Checking authorization
        $this->denyAccessUnlessGranted('ROLE_MODERATOR', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url        = $this->generateUrl('administration_redactorsManagement');
        $referer    = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        // Retrieving admin
        $redactor = $this->get('challengeme.manager.redactor')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.redactor')->delete($redactor);

        // Redirecting
        return $this->redirectToRoute('administration_redactorsManagement');
    }

    /**
     * Reset the password for the given user
     *
     * @param   $id
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function resetPasswordAction($id, Request $request)
    {
        // Retreving the referer
        $referer    = $request->server->get('HTTP_REFERER');

        // Generating url
        $adminUrl       = $this->generateUrl('administration_adminsManagement');
        $moderatorUrl   = $this->generateUrl('administration_moderatorsManagement');
        $redactorUrl    = $this->generateUrl('administration_redactorsManagement');

        // Resetting admin password
        if (false !== strstr($referer, $adminUrl)) {
            // Denying access
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "You are not allowed to access this page");

            // Retrieving the manager
            $manager = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $admin   = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($admin);

            // Redirecting
            return $this->redirectToRoute('administration_adminsManagement', array(
                'success' => 'Password reseted successfully'
            ));
        }

        // Resetting moderator password
        else if (false !== strstr($referer, $moderatorUrl)) {
            // Denying access
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "You are not allowed to access this page");

            // Retrieving the manager
            $manager    = $this->get('challengeme.manager.moderator');

            // Retrieving admin
            $moderator  = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($moderator);

            // Redirecting
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        // Resetting redactor password
        else if (false !== strstr($referer, $redactorUrl)) {
            // Denying access
            $this->denyAccessUnlessGranted('ROLE_MODERATOR', null, "You are not allowed to access this page");

            // Retrieving the manager
            $manager    = $this->get('challengeme.manager.redactor');

            // Retrieving admin
            $redactor   = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($redactor);

            // Redirecting
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        // Resetting admin password
        else {
            // Redirecting
            return $this->redirectToRoute('administration_homepage');
        }
    }
}

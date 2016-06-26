<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Form\AdministratorType;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        return array();
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
        $form   = $this->createForm(AdministratorType::class, $admin);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                )
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
     * @Template("AdminBundle:content:moderators_management.html.twig")
     *
     * @return array
     */
    public function moderatorsManagementAction() {
        return array();
    }

    /**
     * @Template("AdminBundle:content:redactors_management.html.twig")
     *
     * @return array
     */
    public function redactorsManagementAction() {
        return array();
    }
}

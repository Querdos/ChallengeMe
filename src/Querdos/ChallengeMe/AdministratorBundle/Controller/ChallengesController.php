<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 26/02/17
 * Time: 15:45
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Form\CategoryType;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Manager\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ChallengesController extends Controller
{
    /**
     * @Template("AdminBundle:content-challenges:category_management.html.twig")
     *
     * @return array
     */
    public function categoryManagementAction()
    {
        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->container->get("challengeme.manager.category");

        return array(
            'categories' => $categoryManager->all()
        );
    }

    /**
     * @Template("AdminBundle:content-challenges:category_add.html.twig")
     *
     * @param Request $request
     *
     * @return array | RedirectResponse
     */
    public function addCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, array(
            'create' => true
        ));

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            // persisting the newly created category
            $this->get('challengeme.manager.category')->create($category);

            return $this->redirectToRoute('challenges_category_management');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content-challenges:category_update.html.twig")
     *
     * @param   int     $id
     * @param   Request $request
     *
     * @return  array | RedirectResponse
     */
    public function updateCategoryAction($id, Request $request)
    {
        // Retrieving admin
        $category = $this->get('challengeme.manager.category')->readById($id);

        // Building the form
        $form = $this->createForm(CategoryType::class, $category, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Persisting the category
            $this->get('challengeme.manager.category')->update($category);

            // Redirecting to the admins management page
            return $this->redirectToRoute('challenges_category_management');
        }

        return array(
            'title' => $category->getTitle(),
            'form' => $form->createView()
        );
    }

    /**
     * Remove a category
     *
     * @param   int     $id
     * @param   Request $request
     *
     * @return  RedirectResponse
     */
    public function removeCategoryAction($id, Request $request)
    {
        // Checking authorization
        // TODO: Manage restriction in security_access_control.yml
        $this->denyAccessUnlessGranted('ROLE_MODERATOR', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url = $this->generateUrl('challenges_category_management');
        $referer = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('challenges_category_management');
        }

        // Retrieving category
        $category = $this->get('challengeme.manager.category')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.category')->delete($category);

        // Redirecting
        return $this->redirectToRoute('challenges_category_management');
    }
}
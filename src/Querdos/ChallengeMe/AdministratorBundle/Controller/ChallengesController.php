<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 26/02/17
 * Time: 15:45
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Form\CategoryType;
use Querdos\ChallengeMe\AdministratorBundle\Form\ChallengeType;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
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
        if ($form->isSubmitted()) {
            // persisting the newly created category
            $this->get('challengeme.manager.category')->create($category);

            return $this->redirectToRoute('challenges_category_management');
        }

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'form'          => $form->createView(),
            'categories'    => $categories
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
            ))
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Persisting the category
            $this->get('challengeme.manager.category')->update($category);

            // Redirecting to the admins management page
            return $this->redirectToRoute('challenges_category_management');
        }

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'title'         => $category->getTitle(),
            'form'          => $form->createView(),
            'categories'    => $categories
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
        // Retrieving url and the referer
        $url     = $this->generateUrl('challenges_category_management');
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

    /**
     * @Template("AdminBundle:content-challenges:category_details.html.twig")
     *
     * @param $category_id
     *
     * @return array
     */
    public function categoryDetailsAction($category_id)
    {
        // retrieving category manager
        $categoryManager = $this->get('challengeme.manager.category');

        // retrieving categories
        $categories = $categoryManager->all();

        // retrieving the category with given id
        $category = $categoryManager->readById($category_id);

        // retrieving challenges for the retrieved category
        $challenges = $this->get('challengeme.manager.challenge')->readByCategory($category);

        return array(
            'categories'    => $categories,
            'category'      => $category,
            'challenges'    => $challenges
        );
    }

    /**
     * @Template("AdminBundle:content-challenges:challenges_add.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function challengeAddAction(Request $request)
    {
        // retrieving category manager
        $categoryManager = $this->get('challengeme.manager.category');

        // retrieving categories
        $categories = $categoryManager->all();

        // creating new object to be hidrating
        $challenge = new Challenge();

        // Building the form
        $form = $this->createForm(ChallengeType::class, $challenge, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        // handling the form
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // setting the author
            $challenge->setAuthor($this->getUser());

            // Persisting the category
            $this->get('challengeme.manager.challenge')->create($challenge);

            // Redirecting to the admins management page
            return $this->redirectToRoute('challenges_category_details', ["category_id" => $challenge->getCategory()->getId()]);
        }

        return array(
            'categories' => $categories,
            'form'       => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content-challenges:challenge_update.html.twig")
     *
     * @param int     $challenge_id
     * @param Request $request
     *
     * @return array | RedirectResponse
     */
    public function updateChallengeAction($challenge_id, Request $request)
    {
        // retrieving the challenge
        $challenge = $this
            ->get('challengeme.manager.challenge')
            ->readById($challenge_id)
        ;

        // Building the form
        $form = $this->createForm(ChallengeType::class, $challenge, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        // retrieving categories
        $categories = $this
            ->get('challengeme.manager.category')
            ->all()
        ;

        // handling the form
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // updating
            $this
                ->get('challengeme.manager.challenge')
                ->update($challenge)
            ;

            // redirecting
            return $this->redirectToRoute(
                'challenges_challenge_details',
                array(
                    'category_id'   => $challenge->getCategory()->getId(),
                    'challenge_id'  => $challenge->getId()
                )
            );
        }

        // everything ok
        return array(
            'form'  => $form->createView(),
            'categories' => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-challenges:challenge_detail.html.twig")
     *
     * @param int $category_id
     * @param int $challenge_id
     *
     * @return array|RedirectResponse
     */
    public function challengeDetailAction($category_id, $challenge_id)
    {
        // retrieving all categories
        $categories = $this
            ->get('challengeme.manager.category')
            ->all()
        ;

        // retrieving the category
        $category = $this
            ->get('challengeme.manager.category')
            ->readById($category_id)
        ;

        // retrieving the challenge details
        $challenge = $this
            ->get('challengeme.manager.challenge')
            ->readById($challenge_id)
        ;

        // retrieving validations for the retrieved challenge
        $validations = $this
            ->get('challengeme.manager.challenge_solving')
            ->getValidationForChallenge($challenge)
        ;

        return array(
            'categories'    => $categories,
            'category'      => $category,
            'challenge'     => $challenge,
            'validations'   => $validations
        );
    }
}
<?php

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Querdos\ChallengeMe\PlayerBundle\Form\TeamType;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class PlayerController extends Controller
{
    /**
     * @Template("PlayerBundle:content:dashboard.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        // retreiving managers
        $categoryManager  = $this->get('challengeme.manager.category');
        $challengeManager = $this->get('challengeme.manager.challenge');
        $playerManager    = $this->get('challengeme.manager.player');

        // returning array
        return array(
            'categories'        => $categoryManager->all(),
            'categoryCount'     => $categoryManager->count(),
            'challengesCount'   => $challengeManager->count(),
            'playerCount'       => $playerManager->count()
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_players_list.html.twig")
     *
     * @return array
     */
    public function playersListAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // retrieving players
        $players    = $this->get('challengeme.manager.player')->all();

        return array(
            'categories' => $categories,
            'players'    => $players
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_teams_list.html.twig")
     *
     * @return array
     */
    public function teamsListAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // retrieving all teams
        $teams      = $this->get('challengeme.manager.team')->all();

        return array(
            'categories' => $categories,
            'teams'      => $teams
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_my_team.html.twig")
     *
     * @param Request $request
     *
     * @return array | RedirectResponse
     */
    public function myTeamAction(Request $request)
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        $dataToReturn = array(
            'categories' => $categories
        );

        // creating the form only if the user has no team
        if (false === $this->getUser()->hasTeam()) {
            // object for the team to be eventually created
            $team = new Team();

            // creating the form
            $form = $this->createForm(TeamType::class, $team);
            $form
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    ),
                    'translation_domain' => 'forms'
                ));

            // handling request
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                // adding the current user to the team
                $team->addPlayer($this->getUser());

                // setting the current user as the leader
                $team->setLeader($this->getUser());

                // creating the team
                $this->get('challengeme.manager.team')->create($team);

                // finally redirecting to the my team page
                return $this->redirectToRoute('player_my_team');
            }

            // adding the form to the array to return
            $dataToReturn['form'] = $form->createView();
        } else {
            // the user has a team
            $dataToReturn['team'] = $this->getUser()->getTeam();
        }

        // returning data
        return $dataToReturn;
    }
}

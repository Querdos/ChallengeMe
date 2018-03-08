<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 11:00 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Form;


use Ivory\CKEditorBundle\Exception\Exception;
use function PHPSTORM_META\type;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeResource;
use Querdos\ChallengeMe\ChallengesBundle\Manager\ChallengeManager;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\VarDumper\VarDumper;

class UploadChallengeResourceType extends AbstractType
{
    /**
     * @var ChallengeManager
     */
    private $challengeManager;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // retrieving the value given for user
        $user = $options['user'];

        // checking that the given option is not null
        if (null === $options['user']) {
            throw new Exception("Expecting a 'user' option, nothing given");
        }

        // checking that the given option is an instance of Administrator
        if (!($user instanceof Administrator)) {
            throw new Exception("Expecting an 'Administrator' for the user option, '" . gettype($user) . "' given");
        }

        $chalList = array();
        // if the current user is an administrator or a moderator, retrieving the complete list of challenges
        if (Role::ROLE_ADMIN === $user->getRoles() || Role::ROLE_MODERATOR === $user->getRoles()) {
            $challenges = $this->challengeManager->all();
            foreach ($challenges as $challenge) {
                $chalList[$challenge->getTitle()] = $challenge;
            }
        }

        // otherwise, a redactor is only allowed to assign resources to his own challenge
        else {
            // retrieving challenges for the given author
            foreach ($user->getChallenges() as $challenge) {
                $chalList[$challenge->getTitle()] = $challenge;
            }
        }

        $builder
            ->add('challenge', ChoiceType::class, array(
                'label' => 'Associated challenge',
                'label_attr' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr' => array(
                    'class' => 'form-control'
                ),
                'choices' => $chalList
            ))
            ->add('resourceFile', FileType::class, array(
                'label'                 => 'Resource',
                'label_attr'            => array(
                    'class'             => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'                  => array(
                    'class'             => 'dropzone'
                ),
                'required'              => true,
                'translation_domain'    => 'forms'
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'        => ChallengeResource::class,
                'csrf_protection'   => true,
                'csrf_field_name'   => '_token',
                'csrf_token_id'     => 'players_token',

                'user'              => null
            ))
        ;
    }

    /**
     * @param ChallengeManager $challengeManager
     */
    public function setChallengeManager(ChallengeManager $challengeManager)
    {
        $this->challengeManager = $challengeManager;
    }
}
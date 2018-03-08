<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/28/17
 * Time: 3:54 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;

use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UploadAvatarPlayerType
 * @package Querdos\ChallengeMe\PlayerBundle\Form
 */
class UploadAvatarPlayerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', FileType::class, array(
                'label'                 => 'Avatar',
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
                'data_class'        => Player::class,
                'csrf_protection'   => true,
                'csrf_field_name'   => '_token',
                'csrf_token_id'     => 'players_token'
            ))
        ;
    }
}
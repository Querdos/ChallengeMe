<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/19/17
 * Time: 3:54 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;

use Querdos\ChallengeMe\UserBundle\Entity\PlayerRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Name',
                'label_attr'            => array(
                    'class'             => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'                  => array(
                    'class'             => 'form-control col-md-7 col-xs-12'
                ),
                'required'              => true,
                'translation_domain'    => 'forms'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'      => PlayerRole::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'players_token'
            ))
        ;
    }
}
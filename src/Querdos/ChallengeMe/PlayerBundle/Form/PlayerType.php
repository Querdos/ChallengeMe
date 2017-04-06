<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/5/17
 * Time: 2:45 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;


use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Username',
                'label_attr' => array(
                    'class' => 'pf-label'
                ),
                'attr' => array(
                    'class' => 'pf-field form-control'
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'label_attr' => array(
                    'class' => 'pf-label'
                ),
                'attr' => array(
                    'class' => 'pf-field form-control'
                )
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Password',
                'label_attr' => array(
                    'class' => 'pf-label'
                ),
                'attr' => array(
                    'class' => 'pf-field form-control'
                )
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
                'data_class'      => Player::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'players_token'
            ))
        ;
    }

}
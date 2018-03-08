<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/6/17
 * Time: 2:20 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;


use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordResetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password_1', PasswordType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Password'
                ),
                'required' => true,
                'translation_domain' => 'forms'
            ))
            ->add('password_confirmation', PasswordType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Password (confirmation)'
                ),
                'required' => true,
                'translation_domain' => 'forms'
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
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'players_token'
            ))
        ;
    }
}
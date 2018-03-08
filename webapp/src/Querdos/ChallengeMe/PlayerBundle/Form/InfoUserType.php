<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/28/17
 * Time: 3:11 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;

use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'label'             => 'Firstname',
                'required'          => true,
                'translation_domain' => 'forms'
            ))
            ->add('lastName', TextType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'label'             => 'Lastname',
                'required'          => true,
                'translation_domain'=> 'forms'
            ))
            ->add('personalInformation', PersonalInformationType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'      => InfoUser::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'players_token'
            ))
        ;
    }
}
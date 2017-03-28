<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/28/17
 * Time: 3:21 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;


use Querdos\ChallengeMe\UserBundle\Entity\PersonalInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalInformationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', TextType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'label' => 'Address',
                'required' => false,
                'translation_domain' => 'forms'
            ))
            ->add('job', TextType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'label' => 'Job',
                'required' => false,
                'translation_domain' => 'forms'
            ))
            ->add('website', TextType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'label' => 'Website',
                'required' => false,
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
                'data_class'      => PersonalInformation::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'players_token'
            ))
        ;
    }

}
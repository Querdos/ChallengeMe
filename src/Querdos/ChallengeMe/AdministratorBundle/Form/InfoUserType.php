<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',  TextType::class, array(
                'label'         => 'First name',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'  => 'required',
                    'class'     => 'form-control col-md-7 col-xs-12'
                )
            ))
            ->add('lastName',   TextType::class, array(
                'label'         => 'Last name',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'  => 'required',
                    'class'     => 'form-control col-md-7 col-xs-12'
                )
            ))
            ->add('birthday',   DateType::class, array(
                'label'         => 'Birthday',
                'label_attr'    => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'required'       => 'required',
                    'class'          => 'form-control',
                    'data-inputmask' => "'mask': '9999-99-99'"
                ),
                'html5'         => false,
                'widget'        => 'single_text',
                'format'        => 'y-M-d', 
                'data'          => null
            ))
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'administrator_token',
        ));
    }
}

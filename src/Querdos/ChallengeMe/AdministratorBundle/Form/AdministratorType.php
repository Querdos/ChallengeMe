<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministratorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',   TextType::class,        array(
                'label'         => 'Username',
                'label_attr'    => array(
                    'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true,
                'translation_domain' => 'forms'
            ))
            ->add('plain_password',   PasswordType::class,    array(
                'label'         => 'Password',
                'label_attr'    => array(
                    'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'class'     => 'form-control col-md-7 col-xs-12',
                    'value'     =>  $options['create'] ? '' : '********'
                ),
                'required'      => $options['create'],
                'translation_domain' => 'forms'
            ))
            ->add('email',      EmailType::class,       array(
                'label'         => 'Main Email',
                'label_attr'    => array(
                    'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true,
                'translation_domain' => 'forms'
            ))
            ->add('emailBack',  EmailType::class,       array(
                'label'         => 'Secondary email',
                'label_attr'    => array(
                    'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'      => true,
                'translation_domain' => 'forms'
            ))
            ->add('infoUser', InfoUserType::class, array(
                'label'              => '',
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
                'data_class'        => 'Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator',
                'csrf_protection'   => true,
                'csrf_field_name'   => '_token',
                'csrf_token_id'     => 'administrator_token',
            ))
            ->setRequired(
                'create'
            )
        ;
    }
}

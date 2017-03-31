<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/29/17
 * Time: 5:37 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Form;


use Querdos\ChallengeMe\AdministratorBundle\Entity\DatabaseDump;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadDumpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dumpFile', FileType::class, array(
                'label'                 => 'File',
                'label_attr'    => array(
                    'class'             => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr'          => array(
                    'class'             => 'control-label col-md-3 col-sm-3 col-xs-12'
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
                'data_class'        => DatabaseDump::class,
                'csrf_protection'   => true,
                'csrf_field_name'   => '_token',
                'csrf_token_id'     => 'administrator_token'
            ))
        ;
    }
}
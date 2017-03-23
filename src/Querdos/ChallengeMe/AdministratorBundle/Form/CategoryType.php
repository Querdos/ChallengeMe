<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 26/02/17
 * Time: 15:37
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Form;

use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface  $builder
     * @param array                 $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',  TextType::class, array(
                'label' => 'Title',
                'label_attr' => array(
                    'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr' => array(
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'  => true,
                'translation_domain' => 'forms'
            ))
            ->add('description', TextType::class, array(
                'label' => 'Description',
                'label_attr' => array(
                    'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr' => array(
                    'class'     => 'form-control col-md-7 col-xs-12'
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
                'data_class' => Category::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id' => 'administrator_token'
            ))
            ->setRequired(
                'create'
            )
        ;
    }
}
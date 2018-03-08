<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 9:48 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeSolution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, array(
                'label' => 'Solution',
                'label_attr' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                ),
                'attr' => array(
                    'class'     => 'form-control col-md-7 col-xs-12'
                ),
                'required'  => true,
                'translation_domain' => 'forms'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'        => ChallengeSolution::class,
                'csrf_protection'   => true,
                'csrf_field_name'   => '_token',
                'csrf_token_id'     => 'administrator_token'
            ))
            ->setRequired(
                'create'
            )
        ;
    }
}
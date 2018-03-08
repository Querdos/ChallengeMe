<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/28/17
 * Time: 11:39 AM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Form;


use Querdos\ChallengeMe\UserBundle\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'required' => true,
                'translation_domain' => 'forms'
            ))
            ->add('level', IntegerType::class, array(
                'label_attr' => array(
                    'class' => "pf-label"
                ),
                'attr'      => array(
                    'class' => "pf-field form-control"
                ),
                'required' => true,
                'translation_domain' => 'forms'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'      => Skill::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id'   => 'players_token'
            ))
        ;
    }
}
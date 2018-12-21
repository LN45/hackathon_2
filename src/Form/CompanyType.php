<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices=[
            'Resident Lab\'O' => 'resident',
            'Entreprise externe' => 'externe',
        ];
        $bool=['Oui'=>1,'Non'=>0];
        $builder
            ->add('name', TextType::class, [
                'attr' => array('type' => 'text', 'class' => 'color-input size-input'),
                'label' => 'Nom',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => $choices,
                'choice_attr' => function($choices, $key, $value) {
//                     adds a class like attending_yes, attending_no, etc
                    return ['class' => 'ml-3'];
                },
                'expanded' => true,
                'multiple' => false,
                'data' => 'name',
//                'expanded' => 'true',
//                'attr' => array('class' => 'custom-control-input')
//                'attr'=> array('type'=> 'radio', 'class' => 'custom-control-input'),
//                'label' => 'Type'
            ])
            ->add('partenaire', ChoiceType::class, [
                'choices' => $bool,
                'choice_attr' => function($choices, $key, $value) {
//                     adds a class like attending_yes, attending_no, etc
                    return ['class' => 'ml-3'];
                },
                'attr' => array('type' => 'text', 'class' => 'color-input size-input'),
                'label' => 'Partenaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}

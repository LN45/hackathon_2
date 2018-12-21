<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\SatisfactionQuizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SatisfactionQuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bool=['Oui'=>1,'Non'=>0];
        $choices=array(
            'Pas satisfait du tout'=> 0,
            'Peu satisfait'=> 1,
            'Moyennement satisfait'=>2,
            'Plutôt Satisfait'=>3,
            'Totalement satisfait'=>4,
        );
        $builder
            ->add('businessContact', ChoiceType::class, array(
                'choices' => $bool,
                'choice_attr' => function($choices, $key, $value) {
//                     adds a class like attending_yes, attending_no, etc
                    return ['class' => 'ml-3'];
                },
                'attr' => array('type' => 'text', 'class' => 'color-input size-input'),

            ))
            ->add('satisfactionNote', ChoiceType::class, array(
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
            ))
            ->add('contactNumber', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SatisfactionQuizz::class,
        ]);
    }
}

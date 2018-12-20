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
        $builder
            ->add('businessContact', ChoiceType::class, array(
                'choices'=> array(
                    'Yes'=>true,
                    'No' =>false,
                )
            ))
            ->add('satisfactionNote', ChoiceType::class, array(
                'choices'=>array(
                    'Pas satisfait du tout'=> 0,
                    'Peu satisfait'=> 1,
                    'Moyennement satisfait'=>2,
                    'Plutôt Satisfait'=>3,
                    'Totalement satisfait'=>4,
                ),
                'expanded'=>true,
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

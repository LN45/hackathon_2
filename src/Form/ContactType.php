<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email', TextType::class)
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'label'=> 'Compagnie'
            ])
            ->add('event', EntityType::class,[
                'class'=> Event::class,
                'choice_label'=> 'name',
                'label' => 'Evènement'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

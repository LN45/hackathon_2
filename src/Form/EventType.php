<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => array('class' => 'color-input size-input'),
            ])
            ->add('type', TextType::class, [
        'attr' => array('type' => 'text', 'class' => 'color-input size-input'),
        'label' => 'Type',
    ])
            ->add('organizer', TextType::class, [
        'attr' => array('type' => 'text', 'class' => 'color-input size-input'),
        'label' => 'Organisateur',
    ])
            ->add('description', TextareaType::class, [
                'attr' => array('type' => 'text', 'class' => 'color-input size-input'),
                'label' => 'Description',
            ])

            ->add('name', TextType::class, [
            'attr' => array('type' => 'text', 'class' => 'color-input size-input'),
            'label' => 'Nom',
        ])
            ->add('pictureFile', VichImageType::class, [
                'required' => true,
                'download_link' => false,
                'allow_delete' => false,
                'label' => ' ',
                'attr' => array('aria-describedby' => 'fileHelp', 'class' => 'form-control-file')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}

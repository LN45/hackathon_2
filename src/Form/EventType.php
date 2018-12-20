<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('contacts', EntityType::class, [
                'class'=>Contact::class,
                'choice_label'=>'firstName',
                'multiple'=>true,

            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => true,
                'download_link' => false,
                'allow_delete' => false,
                'label' => ' ',
                'attr' => array('aria-describedby' => 'fileHelp', 'class' => 'form-control-file')
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Entrainment;
use App\Entity\Equipe;
use App\Entity\Installationsportive;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EntrainmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Session Name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 3,
                ],
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Start Date & Time',
                'widget' => 'single_text',
                'required' => true,
                'html5' => true, // Add this
                'attr' => ['class' => 'js-datetimepicker'], // Optional: for JS datepicker
                'input' => 'datetime_immutable', // Add this for better handling
            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'End Date & Time',
                'widget' => 'single_text',
                'required' => true,
                'html5' => true, // Add this
                'attr' => ['class' => 'js-datetimepicker'], // Optional
                'input' => 'datetime_immutable', // Add this
            ])
            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom',
                'label' => 'Team',
                'placeholder' => 'Select a Team',
                'required' => true, // Consider making this required
            ])
            ->add('installationSportive', EntityType::class, [
                'class' => Installationsportive::class,
                'choice_label' => 'nom',
                'label' => 'Location',
                'placeholder' => 'Select a Location',
                'required' => true, // Consider making this required
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrainment::class,
        ]);
    }
}
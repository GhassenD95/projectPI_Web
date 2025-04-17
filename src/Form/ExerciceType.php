<?php

namespace App\Form;

use App\Entity\Exercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('typeExercice', ChoiceType::class, [
                'choices' => [
                    'Musculation' => 'MUSCULATION',
                    'Cardio' => 'CARDIO',
                    'Yoga' => 'YOGA',
                    'Pilates' => 'PILATES',
                    'Natation' => 'NATATION',
                    'HIIT' => 'HIIT',
                    'Zumba' => 'ZUMBA',
                ],
                'placeholder' => 'Select an exercise type',
                'attr' => [
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500'
                ],
            ])
            ->add('dureeMinutes')
            ->add('sets')
            ->add('reps')
            ->add('image', FileType::class, [
                'label_attr' => ['class' => "block text-sm font-medium text-gray-900"],
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Please upload a valid JPEG or PNG image',
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). Maximum allowed: {{ limit }} {{ suffix }}'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
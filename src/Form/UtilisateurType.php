<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyles = "mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6";
        $labelStyles = "block text-sm font-medium text-gray-900";

        $builder
            ->add('nom', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
            ])
            ->add('prenom', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
            ])
            ->add('role', ChoiceType::class, [
                'label_attr' => ['class' => $labelStyles],
                'choices' => [
                    'Athlète' => 'ATHLETE',
                    'Coach' => 'COACH',
                    'Manager' => 'MANAGER',
                    'Admin' => 'ADMIN'
                ],
            ])
            ->add('email', EmailType::class, [
                'label_attr' => ['class' => $labelStyles],
            ])
            ->add('password', PasswordType::class, [
                'label_attr' => ['class' => $labelStyles],
            ])
            ->add('adresse', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
                'required' => false,
                'attr' => ['class' => $inputStyles]
            ])
            ->add('telephone', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
                'required' => false,
            ])
            ->add('imageUrl', FileType::class, [
                'label_attr' => ['class' => $labelStyles],
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png']
                    ])
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'attr' => ['class' => 'space-y-6']
        ]);
    }
}
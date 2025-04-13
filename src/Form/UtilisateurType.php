<?php

// src/Form/UtilisateurType.php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormInterface;
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
                'attr' => ['class' => $inputStyles],
                'empty_data' => ''
            ])
            ->add('prenom', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
                'empty_data' => ''
            ])
            ->add('role', ChoiceType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
                'choices' => [
                    'Athlète' => 'ATHLETE',
                    'Coach' => 'COACH',
                    'Manager' => 'MANAGER',
                    'Admin' => 'ADMIN'
                ],
                'empty_data' => 'ATHLETE'
            ])
            ->add('email', EmailType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
                'empty_data' => ''
            ])
            ->add('password', PasswordType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
                'required' => $options['require_password'],
                'empty_data' => '',
                'mapped' => true,
                'constraints' => $options['require_password'] ? [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                        'groups' => ['registration', 'password_update']
                    ]),
                ] : []
            ])
            ->add('adresse', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
                'empty_data' => ''
            ])
            ->add('telephone', TextType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
                'empty_data' => ''
            ])
            ->add('imageUrl', FileType::class, [
                'label_attr' => ['class' => $labelStyles],
                'attr' => ['class' => $inputStyles],
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
            'data_class' => Utilisateur::class,
            'attr' => ['class' => 'space-y-6'],
            'require_password' => true,
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                $groups = ['Default'];

                if (null === $data->getId()) {
                    $groups[] = 'registration';
                } elseif (!empty($form->get('password')->getData())) {
                    $groups[] = 'password_update';
                }

                return $groups;
            }
        ]);
    }
}
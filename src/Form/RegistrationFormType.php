<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'input-pixel'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer un pseudo'),
                    new Length(min: 3, max: 20),
                    new Regex(
                        pattern: '/^[a-zA-Z0-9_]+$/',
                        message: 'Ton pseudo ne peut contenir que des lettres, des chiffres et des underscores (_).'
                    ),
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'input-pixel']
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'input-pixel']
            ])
            ->add('date_de_naissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'input-pixel']
            ])
            ->add('email', null, [
                'attr' => ['class' => 'input-pixel']
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'input-pixel'
                ],
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer un mot de passe'),
                    new Length(
                        min: 12, 
                        minMessage: 'Votre mot de passe doit faire au moins {{ limit }} caractères', 
                        max: 4096
                    ),
                    new Regex(
                        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{12,}$/',
                        message: 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&.).'
                    ),
                    new NotCompromisedPassword(message: 'Ce mot de passe a été trouvé dans une fuite de données. Par sécurité, choisis-en un autre.'),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions.'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
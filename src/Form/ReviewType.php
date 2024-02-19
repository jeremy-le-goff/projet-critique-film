<?php

namespace App\Form;

use App\Entity\Review;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // nom d'utilisateur qui va poster une review (critique)
            ->add('username', TextType::class, [
                // Le label qui va s'afficher juste au dessus du champ
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Courriel',
                'constraints' => [
                    new Email(), // contraintes => ce champ doit etre une adresse mail
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Critique'
            ])
            ->add('rating', ChoiceType::class, [
                'choices'  => [
                    'Excellent' => 5,
                    'Très bon' => 4,
                    'Bon' => 3,
                    'Peut mieux faire' => 2,
                    'A éviter' => 1,
                ],
            ])
            ->add('reactions', ChoiceType::class, [
                'choices'  => [
                    'Rire' => 'smile',
                    'Pleurer' => 'cry',
                    'Réfléchir' => 'think',
                    'Dormir' => 'sleep',
                    'Rêver' => 'dream',
                ],
                // On veut pouvoir cocher plusieurs case en meme temps
                'multiple' => true,
                // Ci dessous juste esthetique, pour que chaque choix ait son propre champ
                'expanded' => true 

            ])
            ->add('watchedAt', DateType::class, [
                'label' => 'Vous avez vu ce film le ',
                'years' => range(date('Y'), date('Y') - 10),
                'input' => 'datetime_immutable'

            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'save',
                ],
            ]);
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}

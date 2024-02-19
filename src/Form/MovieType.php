<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [

                'label' => 'title',

                'required' => false,

            ])
            ->add('release_date', DateType::class, [

                'label' => 'crée le',
                'required' => false,

            ])

            ->add('duration', IntegerType::class, [

                'label' => 'durée',
                'required' => false,

            ])
            ->add('type', textType::class, [

                'label' => 'type',

            ])
            ->add('summary', TextareaType::class, [

                'label' => 'résumé',
                'required' => false,

            ])
            ->add('synopsis', TextareaType::class, [

                'label' => 'synopsis',
                'required' => false,

            ])

            ->add('poster', FileType::class, [

                'label' => 'photo',
                'mapped' => false,
                'required' => false,

            ])
            ->add('rating', IntegerType::class, [

                'label' => 'note',
                'mapped' => false,
                'required' => false,

            ])

            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'save',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}

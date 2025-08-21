<?php

namespace App\Form;

use App\Entity\Serie;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\File;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom de la série',
                'required' => false,
            ])
            ->add('overview', TextareaType::class,[])
            ->add('status', ChoiceType::class,[
                'choices' => [
                    'En cours' => 'returning',
                    'Terminé' => 'ended',
                    'Abandonné' => 'Canceled',
                ]
            ])
            ->add('vote')
            ->add('popularity')
            ->add('genre',ChoiceType::class,[
                'choices' => [
                'Famille' => 'family',
                'Drame' => 'drama',
                'Comedie' => 'comedy',
                'SF' => 'Sci-fi',
                'Fantasy' => 'fantasy',
                'Action' => 'action',
                'Mistère' => 'mistery',
                'Crime' => 'crime'
                    ]
            ])
            ->add('firstAirDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('lastAirDate',DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('backdrop')
            ->add('poster_file', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'nanani',


                            ]
                )]
            ])
            ->add('tmbdId')
            ->add('submit', SubmitType::class);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }



}

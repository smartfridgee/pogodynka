<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('temperature', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'type' => 'number',
                    'step' => 'any',
                    'min' => -50,
                    'max' => 50,
                    'placeholder' => 'Enter temperature',
                ],
            ])
            ->add('wind', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'type' => 'number',
                    'step' => 'any',
                    'min' => 0,
                    'max' => 500,
                    'placeholder' => 'Enter wind speed',
                ],
            ])
            ->add('feelsLike', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'type' => 'number',
                    'step' => 'any',
                    'min' => -50,
                    'max' => 50,
                    'placeholder' => 'Enter what it feels like',
                ],
            ])
            ->add('cloudiness', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'type' => 'number',
                    'step' => 'any',
                    'min' => 0,
                    'max' => 100,
                    'placeholder' => 'Enter cloudiness',
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}

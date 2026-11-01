<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $latitude_max = 90.0;
        $longitude_max = 180.0;
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'Enter city name',
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'United States' => 'US',
                    'Canada' => 'CA',
                    'United Kingdom' => 'GB',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Poland' => 'PL',
                    'Italy' => 'IT',
                    'Spain' => 'ES',
                    'Australia' => 'AU',
                    'New Zealand' => 'NZ',
                ],
                'placeholder' => 'Select a country',
            ])
            ->add('latitude', NumberType::class, [
                'html5' => true, // Gemini podpowiedział mi, że to jest potrzebne by pole renderowało się jako pole typu number a nie text...
                'attr' => [
                    'type' => 'number',
                    'step' => 'any',
                    'min' => -$latitude_max,
                    'max' => $latitude_max,
                    'placeholder' => 'Enter longitude',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'type' => 'number',
                    'step' => 'any',
                    'min' => -$longitude_max,
                    'max' => $longitude_max,
                    'placeholder' => 'Enter longitude',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}

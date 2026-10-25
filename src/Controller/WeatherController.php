<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'weather_by_city', requirements: ['city' => '[a-zA-Z]+'])]
    #[Route('/weather/{city},{country}', name: 'weather_by_city_cc', requirements: ['city' => '[a-zA-Z]+', 'country' => '[a-zA-Z]+'])]
    public function city(?Location $location, ForecastRepository $repository): Response
    {
        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }
        $forecasts = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}

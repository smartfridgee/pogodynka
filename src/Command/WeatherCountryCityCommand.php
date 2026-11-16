<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Add a short description for your command',
)]
class WeatherCountryCityCommand{

    public function __construct(
        private readonly WeatherUtil $weatherUtil,
    ){}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country Code')] string $country,
        #[Argument('City Name')] string $city,
    ): int {
        $forecasts = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        $io->writeln(sprintf('Location: %s, %s', $city, $country));
        $rows = [];
        foreach ($forecasts as $forecast) {
            $rows[] = [
                $forecast->getDate()->format('Y-m-d'),
                $forecast->getTemperature() . '°C',
                $forecast->getFeelsLike() . '°C',
                $forecast->getWind() . ' km/h',
                $forecast->getCloudiness() . '%',
            ];
        }
        $io->table(
            ['Date', 'Temp', 'Feels Like', 'Wind', 'Cloudiness'],
            $rows
        );

        return Command::SUCCESS;
    }
}

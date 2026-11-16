<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Add a short description for your command',
)]
class WeatherLocationCommand{
    public function __construct(
        private readonly WeatherUtil $weatherUtil,
        private readonly LocationRepository $locationRepository,
    ){}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {
        $location = $this->locationRepository->find($id);

        $forecasts = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Location: %s', $location->getCity()));
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

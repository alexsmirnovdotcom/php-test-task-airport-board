<?php

namespace App\Repository;

use App\Entity\Flight;
use App\Service\JsonParser;

class FlightRepository extends AbstractRepository
{
    private const FROM_DATA_KEY = 'from';
    private const TO_DATA_KEY = 'to';
    private const AIRPORT_DATA_KEY = 'airport';
    private const TIME_DATA_KEY = 'time';
    private const DATE_DATA_KEY = 'date';

    private JsonParser $jsonParser;
    private AirportRepository $airportRepository;

    public function __construct(JsonParser $jsonParser, AirportRepository $airportRepository)
    {
        $this->jsonParser = $jsonParser;
        $this->airportRepository = $airportRepository;
    }

    public function getAll(): array
    {
        return $this->getData();
    }

    protected function loadData(): array
    {
        return array_map(
            function (array $flightData): Flight {
                return $this->buildFlight($flightData);
            },
            $this->jsonParser->load('flight.json')
        );
    }

    private function buildFlight(mixed $flightData): Flight
    {
        $this->assertKeysExists($flightData, [
            self::FROM_DATA_KEY,
            self::TO_DATA_KEY
        ]);

        $fromData = $flightData[self::FROM_DATA_KEY];
        $toData = $flightData[self::TO_DATA_KEY];

        $this->assertKeysExists($fromData,
            [
                self::AIRPORT_DATA_KEY,
                self::TIME_DATA_KEY,
                self::DATE_DATA_KEY
            ]
        );

        $this->assertKeysExists($toData,
            [
                self::AIRPORT_DATA_KEY,
                self::TIME_DATA_KEY,
                self::DATE_DATA_KEY
            ]
        );

        $fromAirport = $this->airportRepository->getAirport($fromData[self::AIRPORT_DATA_KEY]);
        $toAirport = $this->airportRepository->getAirport($toData[self::AIRPORT_DATA_KEY]);

        $fromDateTime = $this->buildDateTime(
            $fromData[self::DATE_DATA_KEY],
            $fromData[self::TIME_DATA_KEY],
            $fromAirport->getTimezone()
        );
        $toDateTime = $this->buildDateTime(
            $toData[self::DATE_DATA_KEY],
            $toData[self::TIME_DATA_KEY],
            $toAirport->getTimezone()
        );

        return new Flight(
            $fromAirport,
            $fromDateTime,
            $toAirport,
            $toDateTime,
        );
    }

    private function buildDateTime(string $date, string $time, string $timezone): \DateTime
    {
        return new \DateTime("{$date} {$time}", new \DateTimeZone($timezone));
    }
}
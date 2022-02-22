<?php

namespace App\Entity;

class Flight
{
    private Airport $fromAirport;
    private \DateTime $fromDateTime;
    private Airport $toAirport;
    private \DateTime $toDateTime;

    public function __construct(Airport $fromAirport, \DateTime $fromDateTime, Airport $toAirport, \DateTime $toDateTime)
    {
        $this->fromAirport = $fromAirport;
        $this->fromDateTime = $fromDateTime;
        $this->toAirport = $toAirport;
        $this->toDateTime = $toDateTime;
    }

    public function getFromAirport(): Airport
    {
        return $this->fromAirport;
    }


    public function getToAirport(): Airport
    {
        return $this->toAirport;
    }


    public function calculateDurationMinutes(): int
    {
        return $this->calculateMinutesFromStartDay($this->toTime) - $this->calculateMinutesFromStartDay($this->fromTime);
    }

    private function calculateMinutesFromStartDay(string $time): int
    {
        [$hour, $minutes] = explode(':', $time, 2);

        return 60 * (int) $hour + (int) $minutes;
    }

    public function getFromDateTime(): \DateTime
    {
        return $this->fromDateTime;
    }

    public function getToDateTime(): \DateTime
    {
        return $this->toDateTime;
    }
}
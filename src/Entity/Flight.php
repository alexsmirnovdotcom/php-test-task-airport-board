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
        $interval = date_diff($this->toDateTime, $this->fromDateTime);
        return $this->calculateMinutesFromDateTimeInterval($interval);
    }

    private function calculateMinutesFromDateTimeInterval(\DateInterval $interval): int
    {
        return ($interval->h * 60) + $interval->i;
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
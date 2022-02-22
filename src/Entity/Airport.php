<?php

namespace App\Entity;

class Airport
{
    private string $code;
    private string $name;
    private string $city;
    private string $timezone;

    public function __construct(string $code, string $name, string $city, string $timezone)
    {
        $this->code = $code;
        $this->name = $name;
        $this->city = $city;
        $this->timezone = $timezone;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
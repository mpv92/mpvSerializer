<?php

namespace Mpv92\MpvSerializer\Examples;

class Address
{
    public function __construct(
        public string $street,
        public string $city,
        public string $country,
        public string $zip
    ) {}
}
<?php

namespace Mpv92\MpvSerializer\Examples;
class Flower
{
    public function __construct(
        public string  $name,
        public string  $color,
        public ?string $species = null
    )
    {
    }
}
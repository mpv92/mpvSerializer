<?php

namespace Mpv92\Serializer\Examples;
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
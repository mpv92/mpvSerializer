<?php

namespace Mpv92\Serializer\Examples;

class OrderItem
{
    public function __construct(
        public string $product,
        public int $quantity,
        public float $price
    ) {}
}
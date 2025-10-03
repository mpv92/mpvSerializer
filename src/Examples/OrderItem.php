<?php

namespace Mpv92\MpvSerializer\Examples;

class OrderItem
{
    public function __construct(
        public string $product,
        public int $quantity,
        public float $price
    ) {}
}
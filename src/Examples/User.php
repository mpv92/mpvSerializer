<?php

namespace Mpv92\Serializer\Examples;

use Mpv92\Serializer\Attributes\Collection;

class User
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public \DateTimeImmutable $createdAt,
        #[Collection(Flower::class)]
        public array $flowers = [],
        public ?Address $address = null,
        #[Collection(Order::class)]
        public array $orders = []
    ) {}
}
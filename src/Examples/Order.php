<?php

namespace Mpv92\Serializer\Examples;

use Mpv92\Serializer\Attributes\Collection;

class Order
{
    public function __construct(
        public int $id,
        public \DateTimeImmutable $createdAt,
        #[Collection(OrderItem::class)]
        public array $items = []
    ) {}
}
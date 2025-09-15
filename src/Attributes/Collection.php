<?php

namespace Mpv92\Serializer\Attributes;
#[\Attribute(\Attribute::TARGET_PARAMETER)]
class Collection
{
    public function __construct(
        public string $className
    ) {}
}
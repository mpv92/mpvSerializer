<?php

namespace Mpv92\MpvSerializer\Exceptions;

class MpvSerializerException extends \Exception
{
    const MESSAGE = 'Something went wrong in the MpvSerialiyer.';
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(static::MESSAGE, $code, $previous);
    }
}
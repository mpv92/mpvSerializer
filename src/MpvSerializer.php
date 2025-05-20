<?php

namespace Mpv92\Serializer;

class MpvSerializer
{
    private array $reflectionCache = [];

    public function __construct()
    {

    }

    public function toJson(mixed $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT, 512);
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T
     * @throws \ReflectionException
     */
    public function toModel(array|string $jsonOrArray, string $className): mixed
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Class $className does not exist.");
        }

        $data = is_string($jsonOrArray)
            ? json_decode($jsonOrArray, true)
            : $jsonOrArray;

        if (!is_array($data)) {
            throw new \InvalidArgumentException("Invalid JSON input.");
        }

        // Reflection-Caching
        $reflection = $this->reflectionCache[$className] ??= new \ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $className();
        }

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!array_key_exists($name, $data)) {
                $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                continue;
            }

            $value = $data[$name];

            if ($type instanceof \ReflectionNamedType) {
                $typeName = $type->getName();

                if (!in_array($typeName, ['int', 'float', 'bool', 'string', 'array', 'mixed']) && class_exists($typeName)) {
                    // Rekursiver Aufruf direkt mit Array
                    $args[] = $this->toModel($value, $typeName);
                    continue;
                }
            }

            $args[] = $value;
        }

        return $reflection->newInstanceArgs($args);
    }
}
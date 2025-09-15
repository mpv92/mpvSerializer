<?php

namespace Mpv92\Serializer;

use Mpv92\Serializer\Attributes\Collection;

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
     * @template T of object
     * @param string|array $jsonOrArray
     * @param class-string<T> $className
     * @return T|array<T>
     */
    public function deserialize(string|array $jsonOrArray, string $className): object|array
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Class $className does not exist.");
        }

        $data = is_string($jsonOrArray)
            ? json_decode($jsonOrArray, true, 512, JSON_THROW_ON_ERROR)
            : $jsonOrArray;

        if (!is_array($data)) {
            throw new \InvalidArgumentException("Invalid input, expected array or JSON object.");
        }

        if ($this->isSequentialArray($data)) {
            return array_map(fn($item) => $this->deserialize($item, $className), $data);
        }


        $reflection = $this->reflectionCache[$className] ??= new \ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $className();
        }

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $name = $param->getName();
            $type = $param->getType();

            $value = $data[$name] ?? ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);

            // Attribute "Collection" zeigt von welcher Klasse eine Collection ist
            // => könnt eman allenfalls auch mit phpdoc machen? User[] oder so
            $attributes = $param->getAttributes(Collection::class);
            if (!empty($attributes) && is_array($value)) {
                $attr = $attributes[0]->newInstance();
                $itemClass = $attr->className;

                $args[] = array_map(fn($item) => $this->deserialize($item, $itemClass), $value);
                continue;
            }

            if ($type instanceof \ReflectionNamedType) {
                $typeName = $type->getName();

                if ($type->isBuiltin()) {
                    $args[] = $value;
                    continue;
                }

                if (is_array($value)) {
                    $args[] = $this->deserialize($value, $typeName);
                    continue;
                }

                // Für Generische Klassen
                if ($value !== null) {
                    $args[] = new $typeName($value);
                    continue;
                }
            }

            $args[] = $value;
        }

        return $reflection->newInstanceArgs($args);
    }

    private function isSequentialArray(array $array): bool
    {
        return array_keys($array) === range(0, count($array) - 1);
    }
}
<?php

namespace Slymetrix\LaravelMandrill;

use JsonSerializable;

class KeyValue implements JsonSerializable
{
    private string $key;
    private mixed $value;

    public function __construct(string $key, mixed $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->getKey(),
            'content' => $this->getValue(),
        ];
    }
}

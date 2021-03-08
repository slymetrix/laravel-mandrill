<?php

namespace Slymetrix\LaravelMandrill;

use Illuminate\Support\Str;
use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;

class CaseInsensitiveKeyValueMap implements ArrayAccess, Countable, Iterator, JsonSerializable
{
    private array $array;

    public function __construct(?array $initial = null)
    {
        if (!$initial) {
            $initial = [];
        }

        $this->array = [];

        foreach ($initial as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        if (!is_string($offset)) {
            throw new InvalidArgumentException('Argument offset is not of type string');
        }

        return array_key_exists(Str::upper($offset), $this->array);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if ($this->offsetExists($offset)) {
            return $this->array[Str::upper($offset)];
        }

        return null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_string($offset)) {
            throw new InvalidArgumentException('Argument offset is not of type string');
        }

        $offset = Str::upper($offset);
        $kv = new KeyValue($offset, $value);
        $this->array[$offset] = $kv;
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!is_string($offset)) {
            throw new InvalidArgumentException('Argument offset is not of type string');
        }

        unset($this->array[Str::upper($offset)]);
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function current(): mixed
    {
        return current($this->array);
    }

    public function key()
    {
        return key($this->array);
    }

    public function next(): void
    {
        next($this->array);
    }

    public function rewind(): void
    {
        rewind($this->array);
    }

    public function valid(): bool
    {
        return $this->key() != null;
    }

    public function toArray(): array
    {
        $res =  [];
        foreach ($this->array as $value) {
            $res[$value->getKey()] = $value->getValue();
        }
        return $res;
    }

    public function jsonSerialize()
    {
        return array_map([KeyValue::class, 'jsonSerialize'], $this->array);
    }
}

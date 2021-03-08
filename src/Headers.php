<?php

namespace Slymetrix\LaravelMandrill;

use Illuminate\Support\Str;
use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;
use JsonSerializable;

class Headers implements ArrayAccess, Countable, Iterator, JsonSerializable
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

        return array_key_exists(Str::lower($offset), $this->array);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if ($this->offsetExists($offset)) {
            return $this->array[Str::lower($offset)];
        }

        return null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_string($offset)) {
            throw new InvalidArgumentException('Argument offset is not of type string');
        }

        $this->array[Str::lower($offset)] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!is_string($offset)) {
            throw new InvalidArgumentException('Argument offset is not of type string');
        }

        unset($this->array[Str::lower($offset)]);
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function current(): mixed
    {
        return static::formatHeaderName(current($this->array));
    }

    public function key()
    {
        return static::formatHeaderName(key($this->array));
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
        foreach ($this->array as $key => $value) {
            $res[$key] = $value;
        }
        return $res;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public static function formatHeaderName(?string $header)
    {
        if (!$header) {
            return $header;
        }

        return preg_replace_callback('/(?:^|-)[a-zA-Z]/', function ($matches) {
            return Str::upper($matches[0]);
        }, Str::lower($header));
    }
}

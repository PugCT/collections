<?php

declare(strict_types=1);

namespace PugCT\Common\Collections;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @phpstan-template TKey
 * @template TKey of array-key
 * @template T
 * @template-implements ImmutableCollection<TKey, T>
 */
class ImmutableArrayCollection implements ImmutableCollection
{

    /**
     * @var ArrayCollection
     * @psalm-var ArrayCollection<TKey, T>
     */
    private $elements;

    /**
     * @param array $elements
     *
     * @psalm-param array<TKey, T> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = new ArrayCollection($elements);
    }

    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function count(): int
    {
        return $this->elements->count();
    }

    public function add($element): ImmutableCollection
    {
        $elements = $this->elements->toArray();
        $elements[] = $element;

        return new self($elements);
    }

    public function clear(): ImmutableCollection
    {
        return new self();
    }

    public function contains($element): bool
    {
        return $this->elements->contains($element);
    }

    public function isEmpty(): bool
    {
        return $this->elements->isEmpty();
    }

    public function remove($key): ImmutableCollection
    {
        $removeAt = function ($index) use ($key) {
            return $index !== $key;
        };

        return new self(array_filter($this->elements->toArray(), $removeAt, ARRAY_FILTER_USE_KEY));
    }

    public function removeElement($element): ImmutableCollection
    {
        $removeFrom = function ($value) use ($element) {
            return $value !== $element;
        };

        return new self(array_filter($this->elements->toArray(), $removeFrom));
    }

    public function containsKey($key): bool
    {
        return $this->elements->containsKey($key);
    }
}

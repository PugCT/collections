<?php

declare(strict_types=1);

namespace PugCT\Collections;

use Doctrine\Common\Collections\ArrayCollection;

/**
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
     * @psalm-param array<TKey, T> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = new ArrayCollection($elements);
    }

    public function getIterator(): void
    {
        // TODO: Implement getIterator() method.
    }

    public function offsetExists($offset): void
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset): void
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value): void
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset): void
    {
        // TODO: Implement offsetUnset() method.
    }

    public function count(): int
    {
        return $this->elements->count();
    }

    public function add($element): ImmutableCollection
    {
        $elements = clone $this->elements;
        $elements->add($element);

        return self::fromArrayCollection($elements);
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
        $elements = clone $this->elements;
        $elements->remove($key);

        return self::fromArrayCollection($elements);
    }

    public function removeElement($element): ImmutableCollection
    {
        $elements = clone $this->elements;
        $elements->removeElement($element);

        return self::fromArrayCollection($elements);
    }

    public function containsKey($key): bool
    {
        return $this->elements->containsKey($key);
    }

    public function get($key)
    {
        return $this->elements->get($key);
    }

    public function getKeys(): array
    {
        return $this->elements->getKeys();
    }

    public function getValues(): array
    {
        return $this->elements->getValues();
    }

    public function set($key, $value): ImmutableCollection
    {
        $elements = clone $this->elements;
        $elements->set($key, $value);

        return self::fromArrayCollection($elements);
    }

    public function toArray(): array
    {
        return $this->elements->toArray();
    }

    private static function fromArrayCollection(ArrayCollection $elements): ImmutableCollection
    {
        $instance = new self();
        $instance->elements = $elements;

        return $instance;
    }
}

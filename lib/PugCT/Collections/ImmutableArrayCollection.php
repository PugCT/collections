<?php

declare(strict_types=1);

namespace PugCT\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @template TKey of array-key
 * @template T
 * @template-implements ImmutableCollection<TKey, T>
 */
class ImmutableArrayCollection implements ImmutableCollection
{
    /**
     * @var Collection
     * @psalm-var Collection<TKey, T>
     */
    private $elements;

    /**
     * @psalm-param array<TKey, T> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = new ArrayCollection($elements);
    }

    public function getIterator(): \Traversable
    {
        return $this->elements->getIterator();
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

    public function first()
    {
        return $this->elements->first();
    }

    public function last()
    {
        return $this->elements->last();
    }

    public function key()
    {
        return $this->elements->key();
    }

    public function current()
    {
        return $this->elements->current();
    }

    public function next()
    {
        return $this->elements->next();
    }

    public function exists(\Closure $p): bool
    {
        return $this->elements->exists($p);
    }

    public function filter(\Closure $p): ImmutableCollection
    {
        return self::fromArrayCollection($this->elements->filter($p));
    }

    public function forAll(\Closure $p): bool
    {
        return $this->elements->forAll($p);
    }

    public function map(\Closure $func): ImmutableCollection
    {
        return self::fromArrayCollection($this->elements->map($func));
    }

    public function partition(\Closure $p): array
    {
        $partition = $this->elements->partition($p);

        return [self::fromArrayCollection($partition[0]), self::fromArrayCollection($partition[1])];
    }

    public function indexOf($element)
    {
        return $this->elements->indexOf($element);
    }

    public function slice(int $offset, int $length = null): array
    {
        return $this->elements->slice($offset, $length);
    }

    private static function fromArrayCollection(Collection $elements): ImmutableCollection
    {
        $instance = new self();
        $instance->elements = $elements;

        return $instance;
    }
}

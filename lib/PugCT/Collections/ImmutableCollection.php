<?php

declare(strict_types=1);

namespace PugCT\Collections;

/**
 * @template TKey of array-key
 * @template T
 */
interface ImmutableCollection extends \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * Adds an element at the end of the collection.
     *
     * @param mixed $element the element to add
     *
     * @return ImmutableCollection new collection with the element added
     *
     * @psalm-param T $element
     */
    public function add($element): self;

    /**
     * Clears the collection, removing all elements.
     *
     * @return ImmutableCollection new empty collection
     */
    public function clear(): self;

    /**
     * Checks whether an element is contained in the collection.
     *
     * @param mixed $element the element to search for
     *
     * @return bool TRUE if the collection contains the element, FALSE otherwise
     *
     * @psalm-param T $element
     */
    public function contains($element): bool;

    /**
     * Checks whether the collection is empty (contains no elements).
     *
     * @return bool TRUE if the collection is empty, FALSE otherwise
     */
    public function isEmpty(): bool;

    /**
     * Removes the element at the specified index from the collection.
     *
     * @param string|int $key the key/index of the element to remove
     *
     * @return ImmutableCollection new collection with the element removed
     *
     * @psalm-param TKey $key
     */
    public function remove($key): self;

    /**
     * Removes the specified element from the collection, if it is found.
     *
     * @param mixed $element the element to remove
     *
     * @return ImmutableCollection new collection with the element removed
     *
     * @psalm-param T $element
     */
    public function removeElement($element): self;

    /**
     * Checks whether the collection contains an element with the specified key/index.
     *
     * @param string|int $key the key/index to check for
     *
     * @return bool TRUE if the collection contains an element with the specified key/index, FALSE otherwise
     *
     * @psalm-param TKey $key
     */
    public function containsKey($key): bool;
}

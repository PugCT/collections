<?php

declare(strict_types=1);

namespace PugCT\Collections;

/**
 * @template TKey of array-key
 * @template T
 */
interface ImmutableCollection extends \Countable, \IteratorAggregate
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

    /**
     * Gets the element at the specified key/index.
     *
     * @param string|int $key the key/index of the element to retrieve
     *
     * @return mixed
     *
     * @psalm-param TKey $key
     * @psalm-return T|null
     */
    public function get($key);

    /**
     * Gets all keys/indices of the collection.
     *
     * @return int[]|string[] the keys/indices of the collection
     *
     * @psalm-return TKey[]
     */
    public function getKeys(): array;

    /**
     * Gets all values of the collection.
     *
     * @return array the values of all elements in the collection
     *
     * @psalm-return T[]
     */
    public function getValues(): array;

    /**
     * Sets an element in the collection at the specified key/index.
     *
     * @param string|int $key   the key/index of the element to set
     * @param mixed      $value the element to set
     *
     * @return ImmutableCollection new collection with the element setted
     *
     * @psalm-param TKey $key
     * @psalm-param T $value
     */
    public function set($key, $value): self;

    /**
     * Gets a native PHP array representation of the collection.
     *
     * @psalm-return array<TKey,T>
     */
    public function toArray(): array;

    /**
     * Sets the internal iterator to the first element in the collection and returns this element.
     *
     * @return mixed
     *
     * @psalm-return T|false
     */
    public function first();

    /**
     * Sets the internal iterator to the last element in the collection and returns this element.
     *
     * @return mixed
     *
     * @psalm-return T|false
     */
    public function last();

    /**
     * Gets the key/index of the element at the current iterator position.
     *
     * @return int|string|null
     *
     * @psalm-return TKey|null
     */
    public function key();

    /**
     * Gets the element of the collection at the current iterator position.
     *
     * @return mixed
     *
     * @psalm-return T|false
     */
    public function current();

    /**
     * Moves the internal iterator position to the next element and returns this element.
     *
     * @return mixed
     *
     * @psalm-return T|false
     */
    public function next();

    /**
     * Tests for the existence of an element that satisfies the given predicate.
     *
     * @param \Closure $p the predicate
     *
     * @return bool TRUE if the predicate is TRUE for at least one element, FALSE otherwise
     *
     * @psalm-param Closure(TKey=, T=):bool $p
     */
    public function exists(\Closure $p): bool;

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     *
     * @param \Closure $p the predicate used for filtering
     *
     * @return ImmutableCollection a collection with the results of the filter operation
     *
     * @psalm-param Closure(T=):bool $p
     * @psalm-return ImmutableCollection<TKey, T>
     */
    public function filter(\Closure $p): self;

    /**
     * Tests whether the given predicate p holds for all elements of this collection.
     *
     * @param \Closure $p the predicate
     *
     * @return bool TRUE, if the predicate yields TRUE for all elements, FALSE otherwise
     *
     * @psalm-param Closure(TKey=, T=):bool $p
     */
    public function forAll(\Closure $p): bool;

    /**
     * Applies the given function to each element in the collection and returns
     * a new collection with the elements returned by the function.
     *
     * @return ImmutableCollection
     *
     * @psalm-template U
     * @psalm-param Closure(T=):U $func
     * @psalm-return ImmutableCollection<TKey, U>
     */
    public function map(\Closure $func): self;

    /**
     * Partitions this collection in two collections according to a predicate.
     *
     * @param \Closure $p the predicate on which to partition
     *
     * @return ImmutableCollection[] An array with two elements. The first element contains the collection
     *                               of elements where the predicate returned TRUE, the second element
     *                               contains the collection of elements where the predicate returned FALSE.
     *
     * @psalm-param Closure(TKey=, T=):bool $p
     * @psalm-return array<ImmutableCollection<TKey, T>>
     */
    public function partition(\Closure $p): array;

    /**
     * Gets the index/key of a given element. The comparison of two elements is strict,
     * that means not only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $element the element to search for
     *
     * @return int|string|bool the key/index of the element or FALSE if the element was not found
     *
     * @psalm-param T $element
     * @psalm-return TKey|false
     */
    public function indexOf($element);

    /**
     * Extracts a slice of $length elements starting at position $offset from the collection.
     *
     * If $length is null it returns all elements from $offset to the end of the collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the elements contained in the collection slice is called on.
     *
     * @param int      $offset the offset to start from
     * @param int|null $length the maximum number of elements to return, or null for no limit
     *
     * @psalm-return array<TKey,T>
     */
    public function slice(int $offset, int $length = null): array;
}

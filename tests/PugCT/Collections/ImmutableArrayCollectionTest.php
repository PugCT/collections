<?php

declare(strict_types=1);

namespace PugCT\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PugCT\Collections\ImmutableArrayCollection;

class ImmutableArrayCollectionTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_add_new_element_at_the_end_of_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $newCollection = $collection->add(8);
        self::assertNotSame($newCollection, $collection);
        self::assertCount($collection->count() + 1, $newCollection);
        self::assertTrue($newCollection->contains(8));
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_remove_all_elements_from_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $newCollection = $collection->clear();
        self::assertNotSame($newCollection, $collection);
        self::assertFalse($collection->isEmpty());
        self::assertTrue($newCollection->isEmpty());
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_check_whether_the_collection_is_empty(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->clear()->isEmpty());
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_remove_an_element_at_specified_index_from_the_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->remove(1);
        self::assertNotSame($newCollection, $collection);
        self::assertCount($collection->count() - 1, $newCollection);
        self::assertTrue($collection->contains(2));
        self::assertFalse($newCollection->contains(2));
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_remove_an_element_from_the_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->removeElement(2);
        self::assertNotSame($newCollection, $collection);
        self::assertCount($collection->count() - 1, $newCollection);
        self::assertTrue($collection->contains(2));
        self::assertFalse($newCollection->contains(2));
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_set_an_element_in_the_collection_at_the_specified_index(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->set(1, 4);
        self::assertNotSame($newCollection, $collection);
        self::assertEquals(2, $collection->get(1));
        self::assertEquals(4, $newCollection->get(1));

        $newCollection = $collection->set('A2', 'a3');
        self::assertNotSame($newCollection, $collection);
        self::assertEquals('a2', $collection->get('A2'));
        self::assertEquals('a3', $newCollection->get('A2'));
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_filter_the_collection_by_predicate(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $isNumeric = function ($element): bool {
            return is_numeric($element);
        };

        $newCollection = $collection->filter($isNumeric);
        self::assertNotSame($newCollection, $collection);
        self::assertNotCount($collection->count(), $newCollection);
        self::assertNotContainsOnly('int', $collection);
        self::assertContainsOnly('int', $newCollection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_apply_a_function_to_each_element_in_the_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $convertToString = function ($item): string {
            return (string) $item;
        };

        $newCollection = $collection->map($convertToString);
        self::assertNotSame($newCollection, $collection);
        self::assertCount($collection->count(), $newCollection);
        self::assertNotContainsOnly('string', $collection);
        self::assertContainsOnly('string', $newCollection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_partition_collection_in_two_collections_according_to_a_predicate(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $isNumeric = function ($item): bool {
            return is_numeric($item);
        };

        $partition = $collection->partition($isNumeric);
        $this->assertPartitioned($partition);
        self::assertContainsOnly('int', $partition[0]);
        self::assertNotContainsOnly('int', $partition[1]);
    }

    /**
     * @test
     */
    public function it_allows_to_partition_empty_collection_in_two_empty_collections(): void
    {
        $collection = new ImmutableArrayCollection();
        $isNumeric = function ($item): bool {
            return is_numeric($item);
        };

        $partition = $collection->partition($isNumeric);
        $this->assertPartitioned($partition);
        self::assertTrue($partition[0]->isEmpty());
        self::assertTrue($partition[1]->isEmpty());
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_partition_collection_in_two_collections_which_one_is_empty(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $isBool = function ($item): bool {
            return \is_bool($item);
        };

        $partition = $collection->partition($isBool);
        $this->assertPartitioned($partition);
        self::assertTrue($partition[0]->isEmpty());
        self::assertCount($collection->count(), $partition[1]);
    }

    public function provideElements(): array
    {
        return [
            'elements' => [[1, 'A' => 'a', 2, 'null' => null, 3, 'A2' => 'a2', 'zero' => 0]],
        ];
    }

    private function assertPartitioned(array $partition): void
    {
        self::assertCount(2, $partition);
        self::assertContainsOnlyInstancesOf(ImmutableArrayCollection::class, $partition);
    }
}

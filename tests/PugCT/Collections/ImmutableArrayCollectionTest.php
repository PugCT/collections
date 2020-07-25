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
        self::assertCount($collection->count() + 1, $newCollection);
        self::assertTrue($newCollection->contains(8));
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_remove_all_elements_from_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        $newCollection = $collection->clear();
        self::assertTrue($newCollection->isEmpty());
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_check_whether_an_element_is_contained_in_the_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        self::assertTrue($collection->contains('a'));
        self::assertTrue($collection->contains(2));
        self::assertTrue($collection->contains(null));
        self::assertFalse($collection->contains(16));
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
     */
    public function it_allows_to_remove_an_element_at_specified_index_from_the_collection(): void
    {
        $elements = [1, 'A' => 'a', 2];
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->remove(0);
        self::assertCount($collection->count() - 1, $newCollection);
        self::assertFalse($newCollection->contains(1));

        $newCollection = $newCollection->remove('non-existent');
        self::assertCount($collection->count() - 1, $newCollection);

        $newCollection = $newCollection->remove('A');
        self::assertCount($collection->count() - 2, $newCollection);
        self::assertFalse($newCollection->contains('a'));

        $newCollection = $newCollection->remove(1);
        self::assertCount($collection->count() - 3, $newCollection);
        self::assertFalse($newCollection->contains(2));

        $newCollection = $newCollection->remove('value-to-empty-collection');
        self::assertCount($collection->count() - 3, $newCollection);
        self::assertTrue($newCollection->isEmpty());

        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    /**
     * @test
     */
    public function it_allows_to_remove_an_element_from_the_collection(): void
    {
        $elements = ['A' => 'a', 2, 'null' => null, 'zero' => 0];
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->removeElement(2);
        self::assertCount($collection->count() - 1, $newCollection);
        self::assertFalse($newCollection->contains(2));

        $newCollection = $newCollection->remove('non-existent');
        self::assertCount($collection->count() - 1, $newCollection);

        $newCollection = $newCollection->removeElement(null);
        self::assertCount($collection->count() - 2, $newCollection);
        self::assertFalse($newCollection->contains(null));

        $newCollection = $newCollection->removeElement('a');
        self::assertCount($collection->count() - 3, $newCollection);
        self::assertFalse($newCollection->contains('a'));

        $newCollection = $newCollection->removeElement(0);
        self::assertCount($collection->count() - 4, $newCollection);
        self::assertFalse($newCollection->contains(0));

        $newCollection = $newCollection->remove('value-to-empty-collection');
        self::assertCount($collection->count() - 4, $newCollection);
        self::assertTrue($newCollection->isEmpty());

        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_check_whether_the_collection_contains_an_element_with_key(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);
        self::assertTrue($collection->containsKey('A'));
        self::assertTrue($collection->containsKey(1));
        self::assertTrue($collection->containsKey('null'));
        self::assertFalse($collection->containsKey('non-existent'));
    }

    public function provideElements(): array
    {
        return [
            'elements' => [[1, 'A' => 'a', 2, 'null' => null, 3, 'A2' => 'a2', 'zero' => 0]],
        ];
    }

    private function assertBothCollectionsAreNotEqual(
        ImmutableArrayCollection $newCollection,
        ImmutableArrayCollection $collection
    ): void {
        self::assertInstanceOf(ImmutableArrayCollection::class, $newCollection);
        self::assertNotEquals($newCollection, $collection);
    }
}

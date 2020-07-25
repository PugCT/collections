<?php

declare(strict_types=1);

namespace PugCT\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PugCT\Collections\ImmutableArrayCollection;
use PugCT\Collections\ImmutableCollection;

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
        self::assertFalse($collection->isEmpty());
        self::assertTrue($newCollection->isEmpty());
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
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
        self::assertCount($collection->count() - 1, $newCollection);
        self::assertTrue($collection->contains(2));
        self::assertFalse($newCollection->contains(2));
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_remove_an_element_from_the_collection(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->removeElement(2);
        self::assertCount($collection->count() - 1, $newCollection);
        self::assertTrue($collection->contains(2));
        self::assertFalse($newCollection->contains(2));
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    /**
     * @test
     * @dataProvider provideElements
     */
    public function it_allows_to_set_an_element_in_the_collection_at_the_specified_index(array $elements): void
    {
        $collection = new ImmutableArrayCollection($elements);

        $newCollection = $collection->set(1, 4);
        self::assertEquals(2, $collection->get(1));
        self::assertEquals(4, $newCollection->get(1));
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);

        $newCollection = $collection->set('A2', 'a3');
        self::assertEquals('a2', $collection->get('A2'));
        self::assertEquals('a3', $newCollection->get('A2'));
        $this->assertBothCollectionsAreNotEqual($newCollection, $collection);
    }

    public function provideElements(): array
    {
        return [
            'elements' => [[1, 'A' => 'a', 2, 'null' => null, 3, 'A2' => 'a2', 'zero' => 0]],
        ];
    }

    private function assertBothCollectionsAreNotEqual(
        ImmutableCollection $newCollection,
        ImmutableCollection $collection
    ): void {
        self::assertInstanceOf(ImmutableArrayCollection::class, $newCollection);
        self::assertNotEquals($newCollection, $collection);
    }
}

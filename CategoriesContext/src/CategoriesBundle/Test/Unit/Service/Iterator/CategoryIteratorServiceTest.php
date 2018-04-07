<?php

namespace CategoriesBundle\Test\Unit\Service\Iterator;

use PHPUnit\Framework\TestCase;
use CategoriesBundle\Service\Iterator\CategoryIteratorService;
use CategoriesBundle\Test\Unit\Traits\FixturesTrait;
use \RecursiveIteratorIterator;

/**
 * @coversDefaultClass \CategoriesBundle\Service\Iterator\CategoryIteratorService
 */
class CategoryIteratorServiceTest extends TestCase
{
    use FixturesTrait;

    const FIXTURE_FILE = 'categories.json';

    /**
     * @covers ::getIteratedCategories
     */
    public function testEmptyCategories()
    {
        $categoryIteratorService = new CategoryIteratorService();

        $this->assertNull(
            $categoryIteratorService->getIteratedCategories(null, true)
        );
    }

    /**
     * @covers ::getIteratedCategories
     */
    public function testIteratorShouldNotBeEmpty()
    {
        $categoryIteratorService = new CategoryIteratorService();

        $categories = $this->createCategories(
            $this->loadFixture(self::FIXTURE_FILE)
        );

        $this->assertInstanceOf(
            RecursiveIteratorIterator::class,
            $categoryIteratorService->getIteratedCategories($categories)
        );
    }
}

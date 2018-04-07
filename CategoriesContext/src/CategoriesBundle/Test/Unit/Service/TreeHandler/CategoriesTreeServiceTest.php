<?php

namespace CategoriesBundle\Test\Unit\Service\TreeHandler;

use PHPUnit\Framework\TestCase;
use CategoriesBundle\Test\Unit\Traits\FixturesTrait;
use CategoriesBundle\Service\TreeHandler\CompleteCategoriesTreeService;
use CategoriesBundle\Repository\CategoryRepositoryInterface;
use CategoriesBundle\Service\Iterator\CategoryIteratorService;
use CategoriesBundle\Service\TreeHandler\TreeGeneratorService;
use CategoriesBundle\Service\Transformer\CategoryTransformer;
use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Service\TreeHandler\VisibleChildCategoriesTreeService;
use \Mockery as m;
use CategoriesBundle\Test\Unit\Fixtures\Exception\FixtureNotFoundException;

class CategoriesTreeServiceTest extends TestCase
{
    use FixturesTrait;

    const FIXTURE_FILE = 'categories.json';

    const CATEGORY_SLUG = 'categoryA1-slug';

    /**
     * @var CategoryRepositoryInterface
     */
    private $mockCategoryRepository;

    /**
     * @test
     */
    public function testCompleteTree()
    {
        $categoriesTree = new CompleteCategoriesTreeService(
            $this->mockCategoryRepository,
            $this->mockCategoryIteratorService(),
            $this->mockTreeGeneratorService()
        );

        $tree = $categoriesTree->getTree();
        $this->assertInstanceOf(TreeDto::class, $tree);

        $categories = $tree->getCategories();
        $this->assertCount(7, $categories);

        $lastCategory = end($categories);
        $this->assertEquals(
            'd364b5da-21e6-11e8-9754-0242c0640a02',
            $lastCategory->getId()
        );
    }

    /**
     * @test
     * @expectedException \CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testVisibleChildCategoriesTreeForEmptySlug()
    {
        $categoriesTree = new VisibleChildCategoriesTreeService(
            $this->mockCategoryRepository,
            $this->mockCategoryIteratorService(),
            $this->mockTreeGeneratorService()
        );

        $categoriesTree->getTree();
    }

    /**
     * @test
     */
    public function testVisibleChildCategoriesTree()
    {
        $categoriesTree = new VisibleChildCategoriesTreeService(
            $this->mockCategoryRepository,
            $this->mockCategoryIteratorService(),
            $this->mockTreeGeneratorService()
        );

        $tree = $categoriesTree->getTree(self::CATEGORY_SLUG);
        $this->assertInstanceOf(TreeDto::class, $tree);

        $categories = $tree->getCategories();
        $this->assertCount(3, $categories);

        $lastCategory = end($categories);
        $this->assertEquals(
            'd364b5da-21e6-11e8-9754-0242c0640a02',
            $lastCategory->getId()
        );
    }

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->mockCategoryRepository = $this->mockCategoryRepositoryInterface();
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->mockCategoryRepository = null;

        m::close();
    }

    /**
     * @return CategoryRepositoryInterface
     * @throws FixtureNotFoundException
     */
    private function mockCategoryRepositoryInterface(): CategoryRepositoryInterface
    {
        $categories = $this->createCategories(
            $this->loadFixture(self::FIXTURE_FILE)
        );

        $mock = m::mock(CategoryRepositoryInterface::class);

        $mock->shouldReceive('findByParent')
            ->andReturn($categories);

        $mock->shouldReceive('findBySlug')
            ->with(self::CATEGORY_SLUG)
            ->andReturn(
                $this->findCategoryBySlug($categories, self::CATEGORY_SLUG)
            );

        $mock->shouldReceive('findBySlug')
            ->with(null)
            ->andReturnNull();

        return $mock;
    }

    /**
     * @return CategoryIteratorService
     */
    private function mockCategoryIteratorService(): CategoryIteratorService
    {
        $mock = m::mock(CategoryIteratorService::class)
            ->makePartial();

        return $mock;
    }

    /**
     * @return TreeGeneratorService
     */
    private function mockTreeGeneratorService(): TreeGeneratorService
    {
        return new TreeGeneratorService(
            new CategoryTransformer()
        );
    }

    /**
     * @param array $categories
     * @param string $slug
     * @return array|null
     */
    private function findCategoryBySlug(array $categories, string $slug = null): ?array
    {
        foreach ($categories as $category) {
            if ($category->getSlug() == $slug) {
                return [$category];
            }

            if (!empty($category->getChildren())) {
                return $this->findCategoryBySlug($category->getChildren(), $slug);
            }
        }

        return null;
    }
}

<?php

namespace CategoriesBundle\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use CategoriesBundle\Service\CategoryDataService;
use CategoriesBundle\Repository\CategoryRepositoryInterface;
use \Mockery as m;

class CategoryDataServiceTest extends TestCase
{
    const ERROR_CATEGORY = 'ERROR';
    const NOT_FOUND_CATEGORY = 'BAR';

    /**
     * @var CategoryDataService
     */
    private $categoryDataService;

    /**
     * @expectedException \CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testNotExistingCategoryById()
    {
        $this->categoryDataService->getCategoryById(self::NOT_FOUND_CATEGORY);
    }

    /**
     * @expectedException \CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testNotExistingCategoryBySlug()
    {
        $this->categoryDataService->getCategoryBySlug(self::NOT_FOUND_CATEGORY);
    }

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->categoryDataService = new CategoryDataService(
            $this->mockCategoryRepositoryInterface()
        );
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->categoryDataService = null;

        m::close();
    }

    /**
     * @return CategoryRepositoryInterface
     */
    private function mockCategoryRepositoryInterface(): CategoryRepositoryInterface
    {
        $mock = m::mock(CategoryRepositoryInterface::class);

        $mock->shouldReceive('findOneById')
            ->with(self::NOT_FOUND_CATEGORY)
            ->andReturn(null);

        $mock->shouldReceive('findOneBySlug')
            ->with(self::NOT_FOUND_CATEGORY)
            ->andReturn(null);

        return $mock;
    }
}

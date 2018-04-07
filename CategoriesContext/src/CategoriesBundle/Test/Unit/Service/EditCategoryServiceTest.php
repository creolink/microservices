<?php

namespace CategoriesBundle\Test\Unit\Service;

use Doctrine\ORM\ORMException;
use PHPUnit\Framework\TestCase;
use CategoriesBundle\Service\EditCategoryService;
use CategoriesBundle\Repository\CategoryRepositoryInterface;
use CategoriesBundle\Validator\JsonSchemaValidatorInterface;
use CategoriesBundle\Service\CategoryDataService;
use CategoriesBundle\Entity\Category;
use JMS\Serializer\SerializerInterface;
use \Mockery as m;
use CategoriesBundle\Service\Patcher\DocumentPatcherInterface;

class EditCategoryServiceTest extends TestCase
{
    const ERROR_CATEGORY = 'ERROR';

    /**
     * @var EditCategoryService
     */
    private $editCategoryService;

    /**
     * @expectedException \CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testUpdateCategoryServerError()
    {
        $this->editCategoryService->patchVisibility(
            self::ERROR_CATEGORY,
            $this->createContent()
        );
    }

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->editCategoryService = new EditCategoryService(
            $this->mockJsonSchemaValidatorInterface(),
            $this->mockCategoryDataService(),
            $this->mockCategoryRepositoryInterface(),
            $this->mockSerializerInterface(),
            $this->mockDocumentPatcherInterface()
        );
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->editCategoryService = null;

        m::close();
    }

    /**
     * @return CategoryRepositoryInterface
     */
    private function mockCategoryRepositoryInterface(): CategoryRepositoryInterface
    {
        $mock = m::mock(CategoryRepositoryInterface::class);

        $mock->shouldReceive('update')
            ->andThrow($this->mockORMException());

        return $mock;
    }

    /**
     * @return ORMException
     */
    private function mockORMException(): ORMException
    {
        $mock = m::mock(ORMException::class);

        return $mock;
    }

    /**
     * @return JsonSchemaValidatorInterface
     */
    private function mockJsonSchemaValidatorInterface(): JsonSchemaValidatorInterface
    {
        $mock = m::mock(JsonSchemaValidatorInterface::class);

        $mock->shouldReceive('validate')
            ->andReturn(true);

        return $mock;
    }

    /**
     * @return CategoryDataService
     */
    private function mockCategoryDataService(): CategoryDataService
    {
        $mock = m::mock(CategoryDataService::class);

        $mock->shouldReceive('getCategoryById')
            ->andReturn(
                $this->createCategory()
            );

        return $mock;
    }

    /**
     * @return SerializerInterface
     */
    private function mockSerializerInterface(): SerializerInterface
    {
        $mock = m::mock(SerializerInterface::class);

        $mock->shouldReceive('serialize')
            ->andReturn(
                '{"id":"Foo","isVisible":false,"children":[],"slug":"Bar","name":"FooBar"}'
            );

        $mock->shouldReceive('deserialize')
            ->andReturn(
                $this->createCategory()
            );

        return $mock;
    }

    /**
     * @return DocumentPatcherInterface
     */
    private function mockDocumentPatcherInterface(): DocumentPatcherInterface
    {
        $mock = m::mock(DocumentPatcherInterface::class);

        $mock->shouldReceive('patchDocument')
            ->andReturn(
                '{"id":"Foo","isVisible":true,"children":[],"slug":"Bar","name":"FooBar"}'
            );

        return $mock;
    }

    /**
     * @return Category
     */
    private function createCategory(): Category
    {
         $category = new Category();
         $category->setId('Foo');
         $category->setIsVisible(false);
         $category->setSlug('Bar');
         $category->setName('FooBar');

         return $category;
    }

    /**
     * @return string
     */
    private function createContent(): string
    {
        $operation['op'] = 'replace';
        $operation['path'] = '/isVisible';
        $operation['value'] = true;

        $content = [];
        $content[] = $operation;

        return json_encode($content);
    }
}

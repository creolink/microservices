<?php

namespace CategoriesBundle\Test\Unit\Service;

use CategoriesBundle\Service\Patcher\DocumentPatcherInterface;
use CategoriesBundle\Service\Patcher\CategoryPatcher;
use CategoriesBundle\Exception\CategoryPatchException;
use PHPUnit\Framework\TestCase;
use \Mockery as m;

class CategoryPatcherTest extends TestCase
{
    /**
     * @var DocumentPatcherInterface
     */
    private $categoryPatcher;

    /**
     * @expectedException \CategoriesBundle\Exception\CategoryPatchException
     */
    public function testInvalidPatch()
    {
        $this->categoryPatcher->patchDocument(
            'Foo',
            '',
            $this->createContent()
        );
    }

    /**
     * @test
     */
    public function testPatchCategory()
    {
        $result = $this->categoryPatcher->patchDocument(
            'Foo',
            '{"id":"Foo","isVisible":false,"children":[],"slug":"Bar","name":"FooBar"}',
            $this->createContent()
        );

        $this->assertEquals(
            '{"id":"Foo","isVisible":true,"children":[],"slug":"Bar","name":"FooBar"}',
            $result
        );
    }

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->categoryPatcher = new CategoryPatcher();
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->categoryPatcher = null;

        m::close();
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

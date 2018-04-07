<?php

namespace CategoriesBundle\Test\Functional\Controller\Category;

use Symfony\Component\HttpFoundation\Response;
use CategoriesBundle\Test\Functional\AbstractFunctionalTestCase;

class CreateControllerTest extends AbstractFunctionalTestCase
{
    const PARENT_CATEGORY_ID = 'd364a92c-21e6-11e8-9754-0242c0640a02';
    const CATEGORY_SLUG = 'categoryA4-slug';

    /**
     * @test
     */
    public function testCreateCategoryWithInvalidContent()
    {
        $invalidData = [
            ['name' => 'bar', 'slug' => '', 'parentCategory' => ''],
            ['name' => '', 'slug' => 'bar', 'parentCategory' => ''],
            ['name' => 'bar', 'slug' => 'bar', 'parentCategory' => 'XXX'],
        ];

        foreach ($invalidData as $data) {
            $this->createRequest(
                $this->createContent(
                    $data['name'],
                    $data['slug'],
                    $data['parentCategory']
                )
            );

            $this->assertEquals(
                Response::HTTP_BAD_REQUEST,
                $this->client->getResponse()
                    ->getStatusCode()
            );
        }
    }

    /**
     * @test
     */
    public function testCreateCategoryWithExistingSlug()
    {
        $this->createRequest(
            $this->createContent(
                'foo',
                self::CATEGORY_SLUG
            )
        );

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testCreateMainCategory()
    {
        $categoryData = $this->createCategoryData();

        $category = $this->createCategory(
            $this->createContent(
                $categoryData['name'],
                $categoryData['slug']
            )
        );

        $this->assertNotEmpty($category->id);
        $this->assertEquals($category->slug, $categoryData['slug']);
        $this->assertEquals($category->name, $categoryData['name']);
        $this->assertFalse(isset($category->parentCategory));
    }

    /**
     * @test
     */
    public function testCreateChildCategory()
    {
        $categoryData = $this->createCategoryData();

        $category = $this->createCategory(
            $this->createContent(
                $categoryData['name'],
                $categoryData['slug'],
                self::PARENT_CATEGORY_ID
            )
        );

        $this->assertNotEmpty($category->id);
        $this->assertEquals($category->slug, $categoryData['slug']);
        $this->assertEquals($category->name, $categoryData['name']);
        $this->assertEquals($category->parentCategory->id, self::PARENT_CATEGORY_ID);
    }

    /**
     * @param string $content
     * @return object
     */
    private function createCategory(string $content = ''): object
    {
        $this->createRequest($content);

        $response = $this->client->getResponse();

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $category = $this->getJsonObject(
            $response->getContent()
        );

        return $category;
    }

    /**
     * @param string $name
     * @param string $slug
     * @param string $parentCategory
     * @param bool $isVisible
     * @return string
     */
    private function createContent(
        string $name,
        string $slug,
        string $parentCategory = '',
        bool $isVisible = true
    ): string {
        $content['name'] = $name;
        $content['slug'] = $slug;
        $content['parentCategory'] = $parentCategory;
        $content['isVisible'] = $isVisible;

        return json_encode($content);
    }

    /**
     * @param string $content
     */
    private function createRequest(string $content = '')
    {
        $this->client->request(
            'POST',
            '/api/category',
            [],
            [],
            [],
            $content
        );
    }

    /**
     * @return array
     */
    private function createCategoryData(): array
    {
        $randomValue = mt_rand(1, 1000) . time();

        $name = 'FOO.' . $randomValue;
        $slug = 'foo-' . $randomValue;

        return [
            'name' => $name,
            'slug' => $slug,
        ];
    }
}

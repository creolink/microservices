<?php

namespace CategoriesBundle\Test\Functional\Controller\Category;

use Symfony\Component\HttpFoundation\Response;
use CategoriesBundle\Test\Functional\AbstractFunctionalTestCase;

class UpdateControllerTest extends AbstractFunctionalTestCase
{
    const TESTED_CATEGORY_ID = 'd364a92c-21e6-11e8-9754-0242c0640a02';

    /**
     * @test
     */
    public function testResponseForUpdateWithInvalidCategory()
    {
        $this->createRequest('', 'XXX');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testResponseForUpdateWithInvalidContent()
    {
        $this->createRequest(
            $this->createContent('string', 'string', true)
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
    public function testCorrectResponseForCategoryUpdate()
    {
        $testedValues = [false, true];

        foreach ($testedValues as $value) {
            $this->createRequest(
                $this->createContent('replace', '/isVisible', $value)
            );

            $response = $this->client->getResponse();

            $this->assertEquals(
                Response::HTTP_OK,
                $response->getStatusCode()
            );

            $category = $this->getJsonObject(
                $response->getContent()
            );

            $this->assertEquals($category->id, self::TESTED_CATEGORY_ID);
            $this->assertEquals($category->isVisible, $value);
        }
    }

    /**
     * @param string $op
     * @param string $path
     * @param bool $value
     * @return string
     */
    private function createContent(string $op, string $path, bool $value): string
    {
        $operation['op'] = $op;
        $operation['path'] = $path;
        $operation['value'] = $value;

        $content = [];
        $content[] = $operation;

        return json_encode($content);
    }

    /**
     * @param string $content
     * @param string|null $id
     */
    private function createRequest(string $content = '', string $id = null)
    {
        $categoryId = !empty($id) ? $id : self::TESTED_CATEGORY_ID;

        $this->client->request(
            'PATCH',
            '/api/category/id/' . $categoryId,
            [],
            [],
            [],
            $content
        );
    }
}

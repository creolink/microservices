<?php

namespace CategoriesBundle\Test\Functional\Controller\Category;

use Symfony\Component\HttpFoundation\Response;
use CategoriesBundle\Test\Functional\AbstractFunctionalTestCase;

class GetControllerTest extends AbstractFunctionalTestCase
{
    /**
     * @test
     */
    public function testCorrectResponseForCategoryBySlug()
    {
        $this->client->request('GET', '/api/category/categoryB1-slug');

        $response = $this->client->getResponse();

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $content = $response->getContent();
        $category = $this->getJsonObject($content);

        $this->assertEquals(
            $category->id,
            'd3c56c40-21e6-11e8-9754-0242c0640a02'
        );
    }

    /**
     * @test
     */
    public function testCorrectResponseForCategoryById()
    {
        $this->client->request('GET', '/api/category/id/d3c56c40-21e6-11e8-9754-0242c0640a02');

        $response = $this->client->getResponse();

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $content = $response->getContent();
        $category = $this->getJsonObject($content);

        $this->assertEquals(
            $category->slug,
            'categoryB1-slug'
        );
    }

    /**
     * @test
     */
    public function testInCorrectResponseForCategory()
    {
        $this->client->request('GET', '/api/category/');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testInCorrectResponseForCategoryBySlug()
    {
        $this->client->request('GET', '/api/category/XXX');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testInCorrectResponseForCategoryById()
    {
        $this->client->request('GET', '/api/category/id/XXX');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }
}

<?php

namespace CategoriesBundle\Test\Functional\Controller\Tree;

use Symfony\Component\HttpFoundation\Response;
use CategoriesBundle\Test\Functional\AbstractFunctionalTestCase;

class TreeControllerTest extends AbstractFunctionalTestCase
{
    /**
     * @test
     */
    public function testCorrectFullTreeResponse()
    {
        $this->client->request('GET', '/api/tree');

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testCorrectTreeResponseBySlug()
    {
        $this->client->request('GET', '/api/tree/categoryA4-slug');

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }

    /**
     * @test
     */
    public function testInCorrectTreeResponseBySlug()
    {
        $this->client->request('GET', '/api/tree/');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );

        $this->client->request('GET', '/api/tree/XXX');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );
    }
}

<?php

namespace CategoriesBundle\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class AbstractFunctionalTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->client = static::createClient([
            'environment' => 'test',
            'debug'       => true,
        ]);
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->client = null;
    }

    /**
     * @param string $content
     * @return object
     */
    protected function getJsonObject(string $content): object
    {
        return json_decode($content);
    }
}

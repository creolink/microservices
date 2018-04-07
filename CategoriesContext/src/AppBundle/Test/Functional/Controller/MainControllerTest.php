<?php

namespace AppBundle\Test\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function testMainPage()
    {
        $client = static::createClient([
            'environment' => 'test',
            'debug'       => false,
        ]);

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("http://web.develop/swagger")')->count()
        );
    }
}

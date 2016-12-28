<?php

namespace rmatil\CmsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleCategoryControllerTest extends WebTestCase {

    private static $ENDPOINT_URL = 'api/v1/article-categories';

    public function testIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', self::$ENDPOINT_URL . "/");

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}

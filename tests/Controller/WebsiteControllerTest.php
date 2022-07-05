<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebsiteControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();

        $client->request('GET', '/pl/');
        $this->assertSelectorTextContains('h1', 'Oferta');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testContact()
    {
        $client = static::createClient();

        $client->request('GET', '/pl/kontakt');
        $this->assertSelectorTextContains('h1', 'Kontakt');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testCurriculumVitae()
    {
        $client = static::createClient();

        $client->request('GET', '/pl/curriculum-vitae');
        $this->assertResponseStatusCodeSame(200);
    }
}

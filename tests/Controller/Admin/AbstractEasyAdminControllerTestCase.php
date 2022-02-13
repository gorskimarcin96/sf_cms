<?php

namespace App\Tests\Controller\Admin;

use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractEasyAdminControllerTestCase extends WebTestCase
{
    protected function goTodoPage(): KernelBrowser
    {
        $client = static::createClient();
        $client->loginUser(static::getContainer()->get(UserRepository::class)->findOneBy([]));
        $client->request('GET', $this->getUrlByNavText($client, 'Todo'));

        return $client;
    }

    protected function getUrlByNavText(KernelBrowser $client, string $navText): ?string
    {
        $client->request('GET', '/admin');

        if ($client->getResponse()->isRedirect('/login')) {
            throw new Exception('You are not logged.');
        }

        foreach ($client->getCrawler()->filter('.menu a')->links() as $link) {
            if (trim($link->getNode()->textContent) === $navText) {
                return $link->getUri();
            }
        }

        return null;
    }
}

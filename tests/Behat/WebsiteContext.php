<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class WebsiteContext implements Context
{
    public function __construct(private readonly KernelBrowser $client)
    {
    }

    /**
     * @Given I follow redirect
     */
    public function iShouldBeRedirectTo(): void
    {
        $this->client->followRedirect();
    }

    /**
     * @Given I should be on :path
     */
    public function iShouldBeOn(string $path): void
    {
        Assert::assertSame($path, $this->client->getCrawler()->getUri());
    }

    /**
     * @Given I am on :url
     * @When I go to :url
     */
    public function visit(string $url): void
    {
        $this->client->request('GET', $url);
    }

    /**
     * @Then I should see :text in the :element
     */
    public function iShouldSeeInTheElement(string $element, string $text): void
    {
        Assert::assertSame($text, $this->client->getCrawler()->filter($element)->first()->text());
    }

    /**
     * @Then I should see :text in the :element from position :position
     */
    public function iShouldSeeInTheElementFromPosition(string $element, string $text, int $position): void
    {
        Assert::assertSame($text, $this->client->getCrawler()->filter($element)->eq($position - 1)->text());
    }

    /**
     * @Then I should see :text in article title of :position
     */
    public function iShouldSeeArticleWithTitle(int $article, string $text): void
    {
        Assert::assertSame($text, $this->client->getCrawler()->filter("article h2")->eq($article - 1)->text());
    }

    /**
     * @Given the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe(int $statusCode): void
    {
        Assert::assertSame($statusCode, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @Given I follow to :title
     */
    public function iFollow(string $title): void
    {
        $this->client->clickLink($title);
    }

    /**
     * @Given I send form :formName with data clicking by :buttonName
     */
    public function iSendFormWithData(string $buttonName, string $formName, TableNode $data): void
    {
        $this->client->submitForm($buttonName, [$formName => $data->getHash()[0]]);
    }

    /**
     * @Given the response should contain :title
     */
    public function theResponseShouldContain(string $title): void
    {
        Assert::assertStringContainsString($title, $this->client->getResponse()->getContent());
    }
}
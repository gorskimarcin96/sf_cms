<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\Assert;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class WebsiteContext implements Context
{
    private ?Response $response = null;

    public function __construct(private readonly KernelInterface $kernel)
    {
    }

    /**
     * @Given I am on homepage
     */
    public function iAmOnHomepage(): void
    {
        $this->response = $this->kernel->handle(Request::create("/"));
    }

    /**
     * @Given I should be redirect to :path
     */
    public function iShouldBeRedirectTo(string $path): void
    {
        $this->response = $this->response->getStatusCode() === 302
            ? $this->kernel->handle(Request::create($this->response->getTargetUrl()))
            : throw new \LogicException();
    }

    /**
     * @Given I should be on :path
     */
    public function iShouldBeOn(string $path): void
    {
        Assert::assertSame($path, $this->response->getTargetUrl());
    }

    /**
     * @Given /^(?:|I )am on "(?P<page>[^"]+)"$/
     * @When /^(?:|I )go to "(?P<page>[^"]+)"$/
     */
    public function visit(string $page): void
    {
        $this->response = $this->kernel->handle(Request::create($page));
    }

    /**
     * @Then I should see :text in the :element
     */
    public function iShouldSeeInTheElement(string $element, string $text): void
    {
        $response = new Crawler($this->response->getContent());
        Assert::assertSame($text, $response->filter($element)->first()->text());
    }

    /**
     * @Then I should see :text in the :element from position :position
     */
    public function iShouldSeeInTheElementFromPosition(string $element, string $text, int $position): void
    {
        $response = new Crawler($this->response->getContent());
        Assert::assertSame($text, $response->filter($element)->eq($position - 1)->text());
    }

    /**
     * @Then I should see :text in article title of :position
     */
    public function iShouldSeeArticleWithTitle(int $article, string $text): void
    {
        $response = new Crawler($this->response->getContent());
        Assert::assertSame($text, $response->filter("article h2")->eq($article - 1)->text());
    }
}

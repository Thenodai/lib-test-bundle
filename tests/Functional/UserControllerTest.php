<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Thenodai\Bundle\TestCaseBundle\TestCase\FunctionalTestCase;

class UserControllerTest extends FunctionalTestCase
{
    /**
     * @var Router
     */
    private $router;

    private $client;

    protected function setUp(): void
    {
        $this->client = $this->getClientWithFixtures([self::class]);

        $this->router = $this->container->get('router');
    }

    public function testGetUsernames(): void
    {
        $response = $this->client->sendRequest(
            Request::METHOD_GET,
            $this->router->generate('test.application.get_usernames')
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['socrates'], json_decode($response->getContent(), true));
    }

    public function testGetUserAssets()
    {
        $response = $this->client->sendRequest(
            Request::METHOD_GET,
            $this->router->generate('test.application.get_usernames')
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['socrates'], json_decode($response->getContent(), true));
    }
}

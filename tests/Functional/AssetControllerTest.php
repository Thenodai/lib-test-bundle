<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Thenodai\Bundle\TestCaseBundle\TestCase\FunctionalTestCase;

class AssetControllerTest extends FunctionalTestCase
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

    public function testGetUserAssets(): void
    {
        $response = $this->client->sendRequest(
            Request::METHOD_GET,
            $this->router->generate('test.application.get_user_assets', ['id' => 1])
        );
        $decoded = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(1, $decoded);
        $this->assertEquals('asset-1', $decoded[1]);
    }
}

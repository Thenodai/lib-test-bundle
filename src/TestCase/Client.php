<?php

declare(strict_types=1);

namespace Thenodai\Bundle\TestCaseBundle\TestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class Client
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function sendRequest(
        string $method,
        string $uri,
        string $contents = null,
        array $headers = []
    ): Response {

        $request = $this->createRequest($method, $uri, $contents, $headers);
        try {
            return $this->kernel->handle($request);
        } catch (HttpException $exception) {
            return new Response($exception->getMessage(), $exception->getStatusCode(), $exception->getHeaders());
        }
    }

    public function createRequest(
        string $method,
        string $uri,
        string $contents = null,
        array $headers = []
    ): Request {
        $parts = parse_url($uri);
        parse_str($parts['query'] ?? '', $query);

        $request = new Request($query, [], [], [], [], array_filter([
           'REQUEST_URI' => $parts['path'],
           'REQUEST_METHOD' => $method,
        ]), $contents);

        $request->headers->add($headers);

        return $request;
    }
}

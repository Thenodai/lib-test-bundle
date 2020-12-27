<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Functional;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Thenodai\Bundle\TestCaseBundle\TestCase\FunctionalTestCase;

class LoadContainerTest extends FunctionalTestCase
{
    public function testLoadContainer(): void
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->setUpContainer());
    }
}

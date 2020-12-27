<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Functional;

use Thenodai\Bundle\Test\Application\Entity\User;
use Thenodai\Bundle\TestCaseBundle\TestCase\FunctionalTestCase;

class LoadDatabaseTest extends FunctionalTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $this->getClientWithFixtures([self::class]);

        $this->entityManager = $this->getEntityManager();
    }

    public function testLoadDatabase(): void
    {
        $repository = $this->entityManager->getRepository(User::class);
        $this->assertInstanceOf(User::class, $repository->find(1));
    }

    public function testSequentialTest(): void
    {
        $repository = $this->entityManager->getRepository(User::class);
        $users = $repository->findAll();
        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals('socrates', $users[0]->getUsername());
    }

    public function testMultipleFixtures(): void
    {
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->find(1);
        $this->assertCount(1, $user->getAssets());
    }
}

<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Application\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Thenodai\Bundle\Test\Application\Entity\User;

class UserController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route(path="/usernames", name="test.application.get_usernames", methods={"GET"})
     */
    public function getUsernames(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(User::class);

        $result = [];
        foreach ($repository->findAll() as $user) {
            $result[] = $user->getUsername();
        }

        return new JsonResponse($result);
    }
}

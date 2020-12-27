<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Application\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Thenodai\Bundle\Test\Application\Entity\Asset;
use Thenodai\Bundle\Test\Application\Entity\User;

class AssetController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route(path="/user/{id}/assets", name="test.application.get_user_assets", methods={"GET"})
     */
    public function getUserAssets(Request $request): Response
    {
        $userId = $request->get('id');
        $repository = $this->entityManager->getRepository(User::class);

        /** @var User $user */
        $user = $repository->find($userId);

        $result = [];
        /** @var Asset $asset */
        foreach ($user->getAssets() as $asset) {
            $result[$asset->getId()] = $asset->getName();
        }

        return new JsonResponse($result);
    }
}

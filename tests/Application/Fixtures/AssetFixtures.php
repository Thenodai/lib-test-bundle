<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Application\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Thenodai\Bundle\Test\Application\Entity\Asset;
use Thenodai\Bundle\Test\Functional\AssetControllerTest;
use Thenodai\Bundle\Test\Functional\LoadDatabaseTest;
use Thenodai\Bundle\Test\Functional\UserControllerTest;

class AssetFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $asset = new Asset();
        $asset->setName('asset-1');
        $asset->setQuantity(1);

        $this->setReference('asset', $asset);
        $manager->persist($asset);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [LoadDatabaseTest::class, UserControllerTest::class, AssetControllerTest::class];
    }
}

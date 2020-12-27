<?php

declare(strict_types=1);

namespace Thenodai\Bundle\Test\Application\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Thenodai\Bundle\Test\Application\Entity\User;
use Thenodai\Bundle\Test\Functional\AssetControllerTest;
use Thenodai\Bundle\Test\Functional\LoadDatabaseTest;
use Thenodai\Bundle\Test\Functional\UserControllerTest;

class UserFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('socrates')
            ->setPassword(sha1('test'))
        ;

        $user->addAsset($this->getReference('asset'));
        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [LoadDatabaseTest::class, UserControllerTest::class, AssetControllerTest::class];
    }

    public function getDependencies()
    {
        return [AssetFixtures::class];
    }
}

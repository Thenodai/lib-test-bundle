<?php

declare(strict_types=1);

namespace Thenodai\Bundle\TestCaseBundle\TestCase;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class FunctionalTestCase extends TestCase
{
    /**
     * @var KernelInterface
     */
    protected $kernel;
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected function getClientWithFixtures(array $fixtures): Client
    {
        $this->setUpContainer();
        $entityManager = $this->getEntityManager();
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadata);

        $arrayInput = new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--group' => $fixtures,
            '--quiet',
        ]);
        $arrayInput->setInteractive(false);

        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $application->run($arrayInput);

        return new Client($this->kernel);
    }

    protected function setUpContainer(): ContainerInterface
    {
        $class = $_SERVER['KERNEL_CLASS'];
        $this->kernel = new $class($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);

        $this->kernel->boot();
        $this->container = $this->kernel->getContainer();

        return $this->container;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        $container = $this->kernel->getContainer()->get('service_container');

        return $container->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        $this->kernel->shutdown();

        $fs = new Filesystem();
        $fs->remove($this->kernel->getCacheDir());
    }
}

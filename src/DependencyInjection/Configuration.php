<?php

declare(strict_types=1);

namespace Thenodai\Bundle\TestCaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('thenodai_test_case');

        return $treeBuilder;
    }
}

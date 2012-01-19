<?php

namespace Profiler\LiveBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class SetProfilerClassesPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('profiler.storage')) {
            return;
        }

        $supported = array(
            'sqlite'  => 'Profiler\LiveBundle\Profiler\Storage\SqliteProfilerStorage',
            'mysql'   => 'Profiler\LiveBundle\Profiler\Storage\MysqlProfilerStorage',
        );

        list($class, ) = explode(':', $container->getParameter('profiler.storage.dsn'));
        if (!isset($supported[$class])) {
            throw new \LogicException(sprintf('Driver "%s" is not supported for the live profiler.', $class));
        }

        $container->getDefinition('profiler.storage')
            ->setPublic(true)
            ->setClass($supported[$class]);

        $classes = array(
            'data_collector.request',
            'data_collector.memory',
            'data_collector.timer',
            'data_collector.exception',
            'data_collector.doctrine',
            'swiftmailer.data_collector',
        );

        foreach ($classes as $class) {
            if ($container->hasDefinition($class)) {
                $container->getDefinition($class)->setClass($container->getParameter("profiler_live.$class.class"));
            }
        }
    }
}

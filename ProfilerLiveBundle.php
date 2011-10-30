<?php

namespace Profiler\LiveBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle,
    Symfony\Component\DependencyInjection\ContainerInterface,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Compiler\PassConfig,
    Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Profiler\LiveBundle\DependencyInjection\Compiler\SetProfilerClassesPass;

class ProfilerLiveBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SetProfilerClassesPass(), PassConfig::TYPE_OPTIMIZE);
    }
}

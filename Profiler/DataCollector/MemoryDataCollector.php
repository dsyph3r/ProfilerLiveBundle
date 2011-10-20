<?php

namespace Profiler\LiveBundle\Profiler\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector as BaseMemoryDataCollector;

class MemoryDataCollector extends BaseMemoryDataCollector
{
    public function getLiveData()
    {
        return array(
            'memory' => array(
                'memory'    => $this->getMemory(),
            ),
        );
    }
}

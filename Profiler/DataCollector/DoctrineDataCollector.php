<?php

namespace Profiler\LiveBundle\Profiler\DataCollector;

use Symfony\Bridge\Doctrine\DataCollector\DoctrineDataCollector as BaseDoctrineDataCollector;

class DoctrineDataCollector extends BaseDoctrineDataCollector
{
    public function getLiveData()
    {
        return array(
            'database' => array(
                'query_count'       => $this->getQueryCount(),
                'time'              => round($this->getTime() * 1000),
            ),
        );
    }
}

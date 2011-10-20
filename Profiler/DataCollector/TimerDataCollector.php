<?php

namespace Profiler\LiveBundle\Profiler\DataCollector;

use Symfony\Bundle\FrameworkBundle\DataCollector\TimerDataCollector as BaseTimerDataCollector;

class TimerDataCollector extends BaseTimerDataCollector
{
    public function getLiveData()
    {
        return array(
            'timer' => array(
                'time'    => round($this->getTime() * 1000),
            ),
        );
    }
}

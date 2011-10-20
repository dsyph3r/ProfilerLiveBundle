<?php

namespace Profiler\LiveBundle\Profiler\DataCollector;

use Symfony\Bundle\FrameworkBundle\DataCollector\RequestDataCollector as BaseRequestDataCollector;

class RequestDataCollector extends BaseRequestDataCollector
{
    public function getLiveData()
    {
        return array(
            'request' => array(
                'request_method'    => $this->getRequestServer()->get('REQUEST_METHOD'),
                'request_uri'       => $this->getRequestServer()->get('REQUEST_URI'),
            ),
            'response' => array(
                'status_code'       => $this->getStatusCode(),
                'format'            => $this->getFormat(),
                'content_type'      => $this->getContentType(),
                'controller'        => $this->getRequestAttributes()->get('_controller'),
                'route'             => $this->getRequestAttributes()->get('_route'),
            ),
        );
    }
}

<?php

namespace Profiler\LiveBundle\Profiler\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector as BaseExceptionDataCollector;

class ExceptionDataCollector extends BaseExceptionDataCollector
{
    public function getLiveData()
    {
        $exception = array('exception' => array());
        if (true === $this->hasException())
        {
            $namespaceClass = $this->getException()->getClass();
            $class = (false === strrpos($namespaceClass, '\\')) ?
                $namespaceClass : substr($namespaceClass, strrpos($namespaceClass, '\\')+1);

            $exception = array(
                'exception' => array(
                    'class'                 => $class,
                    'namespace_class'       => $namespaceClass,
                    'message'               => $this->getMessage(),
                    'status_code'           => $this->getStatusCode(),
                ),
            );
        }

        return $exception;
    }
}

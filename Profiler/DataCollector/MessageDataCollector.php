<?php

namespace Profiler\LiveBundle\Profiler\DataCollector;

use Symfony\Bridge\Swiftmailer\DataCollector\MessageDataCollector as BaseMessageDataCollector;

class MessageDataCollector extends BaseMessageDataCollector
{
    public function getLiveData()
    {
        return array(
            'mailer' => array(
                'message_count'       => $this->getMessageCount(),
                'is_spool'            => $this->isSpool(),
            ),
        );
    }
}

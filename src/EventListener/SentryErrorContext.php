<?php

namespace App\EventListener;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Network\Request;

/**
 * Class SentryErrorContext
 * @package App\EventListener
 */
class SentryErrorContext implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'CakeSentry.Client.beforeCapture' => 'setContext',
        ];
    }

    public function setContext(Event $event)
    {
        /** @var Request $request */
        $request = $event->getSubject()->getRequest();
        $request->trustProxy = true;

        /** @var \Raven_Client $raven */
        $raven = $event->getSubject()->getRaven();
        $raven->user_context([
            'ip_address' => $request->clientIp()
        ]);
        $raven->tags_context([
            'env' => Configure::read('env', 'not-set')
        ]);

        return [
            'extra' => [
                'request' => json_encode($request),
            ]
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SetCurrentPageSubscriber implements EventSubscriberInterface
{
    public function onKernelView(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $data = $request->attributes->get('data');

        $data->setCurrentPage($request->query->getInt('page', 1));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelView',
        ];
    }
}

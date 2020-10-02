<?php


namespace Jeansf\Common\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class BeforeActionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'convertJsonToArray'
        ];
    }

    public function convertJsonToArray(ControllerEvent $event) {
        $request = $event->getRequest();

        if($request->getContentType() != 'json' || !$request->getContent()) {
            return ;
        }

        $data = json_decode($request->getContent(), true);

        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('JSON inválido! ' . json_last_error_msg());
        }
        $request->request->replace(is_array($data) ? $data : array());
    }
}

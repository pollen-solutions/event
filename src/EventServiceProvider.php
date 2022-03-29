<?php

declare(strict_types=1);

namespace Pollen\Event;

use Pollen\Container\BootableServiceProvider;
use Pollen\Kernel\Events\ConfigLoadEvent;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EventServiceProvider extends BootableServiceProvider
{
    protected $provides = [
        EventDispatcherInterface::class
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        try {
            /** @var EventDispatcherInterface $event */
            if ($event = $this->getContainer()->get(EventDispatcherInterface::class)) {
                $event->subscribeTo('config.load', static function (ConfigLoadEvent $event) {
                    if (is_callable($config = $event->getConfig('event'))) {
                        $config($event->getApp()->get(EventDispatcherInterface::class), $event->getApp());
                    }
                });
            }
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            unset($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(EventDispatcherInterface::class, function () {
            return new EventDispatcher($this->getContainer());
        });
    }
}
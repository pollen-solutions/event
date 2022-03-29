<?php

declare(strict_types=1);

namespace Pollen\Event;

use League\Event\EventDispatcher as BaseEventDispatcher;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

/**
 * @mixin BaseEventDispatcher
 */
interface EventDispatcherInterface extends ContainerProxyInterface, PsrEventDispatcherInterface
{
    /**
     * Register a listener for a triggered event.
     *
     * @param string $name
     * @param string|callable $listener
     * @param int $priority
     *
     * @return void
     */
    public function on(string $name, $listener, int $priority = 0): void;

    /**
     * Register an unique listener for a triggered event.
     * {@internal This listener will only be called once.}
     *
     * @param string $name
     * @param string|callable $listener
     * @param int $priority
     *
     * @return void
     */
    public function one(string $name, $listener, int $priority = 0): void;

    /**
     * Dispatch all listeners attached to this triggered event.
     *
     * @param string $event
     * @param array $args
     *
     * @return TriggeredEventInterface
     */
    public function trigger(string $event, array $args = []): TriggeredEventInterface;
}
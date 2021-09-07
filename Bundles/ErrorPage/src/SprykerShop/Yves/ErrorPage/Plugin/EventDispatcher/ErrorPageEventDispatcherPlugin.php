<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ErrorPage\Plugin\EventDispatcher;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\EventDispatcher\EventDispatcherInterface;
use Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @method \SprykerShop\Yves\ErrorPage\ErrorPageFactory getFactory()
 */
class ErrorPageEventDispatcherPlugin extends AbstractPlugin implements EventDispatcherPluginInterface
{
    /**
     * @var int
     */
    protected const PRIORITY = 50;

    /**
     * {@inheritDoc}
     * - Adds a listener for the `\Symfony\Component\HttpKernel\KernelEvents::EXCEPTION` event.
     * - Executes `\SprykerShop\Yves\ErrorPageExtension\Dependency\Plugin\ExceptionHandlerPluginInterface` which is able to handle the current status code.
     *
     * @api
     *
     * @param \Spryker\Shared\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Shared\EventDispatcher\EventDispatcherInterface
     */
    public function extend(EventDispatcherInterface $eventDispatcher, ContainerInterface $container): EventDispatcherInterface
    {
        $eventDispatcher->addListener(KernelEvents::EXCEPTION, function (ExceptionEvent $event) {
            $this->onKernelException($event);
        }, static::PRIORITY);

        return $eventDispatcher;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\ExceptionEvent $event
     *
     * @return void
     */
    protected function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        $exceptionHandlerPlugins = $this->getFactory()->getExceptionHandlerPlugins();
        foreach ($exceptionHandlerPlugins as $exceptionHandlerPlugin) {
            if (!$exceptionHandlerPlugin->canHandle($statusCode)) {
                continue;
            }

            $response = $exceptionHandlerPlugin->handleException(FlattenException::createFromThrowable($exception));

            $event->setResponse($response);
            $event->stopPropagation();

            break;
        }
    }
}

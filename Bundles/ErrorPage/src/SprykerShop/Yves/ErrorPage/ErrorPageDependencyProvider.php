<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ErrorPage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;

class ErrorPageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const PLUGIN_APPLICATION = 'PLUGIN_APPLICATION';
    public const PLUGIN_EXCEPTION_HANDLERS = 'PLUGIN_EXCEPTION_HANDLERS';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addApplicationPlugin($container);
        $container = $this->createExceptionHandlerPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addApplicationPlugin(Container $container)
    {
        $container->set(static::PLUGIN_APPLICATION, function () {
            $pimplePlugin = new Pimple();

            return $pimplePlugin->getApplication();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function createExceptionHandlerPlugins(Container $container)
    {
        $container->set(static::PLUGIN_EXCEPTION_HANDLERS, function () {
            return $this->getExceptionHandlerPlugins();
        });

        return $container;
    }

    /**
     * @return \SprykerShop\Yves\ErrorPage\Dependency\Plugin\ExceptionHandlerPluginInterface[]
     */
    protected function getExceptionHandlerPlugins()
    {
        return [];
    }
}

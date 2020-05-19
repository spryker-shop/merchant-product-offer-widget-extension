<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\SalesReturnPage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\SalesReturnPage\Dependency\Client\SalesReturnPageToCustomerClientBridge;
use SprykerShop\Yves\SalesReturnPage\Dependency\Client\SalesReturnPageToSalesClientBridge;
use SprykerShop\Yves\SalesReturnPage\Dependency\Client\SalesReturnPageToSalesReturnClientBridge;
use SprykerShop\Yves\SalesReturnPage\Dependency\Client\SalesReturnPageToStoreClientBridge;

class SalesReturnPageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';
    public const CLIENT_SALES_RETURN = 'CLIENT_SALES_RETURN';
    public const CLIENT_SALES = 'CLIENT_SALES';
    public const CLIENT_STORE = 'CLIENT_STORE';

    public const PLUGINS_RETURN_CREATE_FORM_EXPANDER = 'PLUGINS_RETURN_CREATE_FORM_EXPANDER';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addSalesReturnClient($container);
        $container = $this->addSalesClient($container);
        $container = $this->addCustomerClient($container);
        $container = $this->addStoreClient($container);

        $container = $this->addReturnCreateFormExpanderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSalesReturnClient(Container $container): Container
    {
        $container->set(static::CLIENT_SALES_RETURN, function (Container $container) {
            return new SalesReturnPageToSalesReturnClientBridge(
                $container->getLocator()->salesReturn()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSalesClient(Container $container): Container
    {
        $container->set(static::CLIENT_SALES, function (Container $container) {
            return new SalesReturnPageToSalesClientBridge(
                $container->getLocator()->sales()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container->set(static::CLIENT_CUSTOMER, function (Container $container) {
            return new SalesReturnPageToCustomerClientBridge(
                $container->getLocator()->customer()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStoreClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORE, function (Container $container) {
            return new SalesReturnPageToStoreClientBridge(
                $container->getLocator()->store()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addReturnCreateFormExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_RETURN_CREATE_FORM_EXPANDER, function () {
            return $this->getReturnCreateFormExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return \SprykerShop\Yves\SalesReturnPageExtension\Dependency\Plugin\ReturnCreateFormExpanderPluginInterface[]
     */
    protected function getReturnCreateFormExpanderPlugins(): array
    {
        return [];
    }
}

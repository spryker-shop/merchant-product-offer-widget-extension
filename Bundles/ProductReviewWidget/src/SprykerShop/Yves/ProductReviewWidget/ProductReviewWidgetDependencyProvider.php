<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductReviewWidget;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;
use SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToCustomerClientBridge;
use SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToProductReviewClientBridge;
use SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToProductReviewStorageClientBridge;

class ProductReviewWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';
    public const CLIENT_PRODUCT = 'CLIENT_PRODUCT';
    public const CLIENT_PRODUCT_REVIEW = 'CLIENT_PRODUCT_REVIEW';
    public const CLIENT_PRODUCT_REVIEW_STORAGE = 'CLIENT_PRODUCT_REVIEW_STORAGE';

    public const PLUGIN_APPLICATION = 'PLUGIN_APPLICATION';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCustomerClient($container);
        $container = $this->addProductReviewClient($container);
        $container = $this->addProductReviewStorageClient($container);
        $container = $this->addPluginApplication($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCustomerClient(Container $container)
    {
        $container->set(static::CLIENT_CUSTOMER, function (Container $container) {
            return new ProductReviewWidgetToCustomerClientBridge($container->getLocator()->customer()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductReviewClient(Container $container)
    {
        $container->set(static::CLIENT_PRODUCT_REVIEW, function (Container $container) {
            return new ProductReviewWidgetToProductReviewClientBridge($container->getLocator()->productReview()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductReviewStorageClient(Container $container)
    {
        $container->set(static::CLIENT_PRODUCT_REVIEW_STORAGE, function (Container $container) {
            return new ProductReviewWidgetToProductReviewStorageClientBridge($container->getLocator()->productReviewStorage()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPluginApplication(Container $container): Container
    {
        $container->set(static::PLUGIN_APPLICATION, function () {
            return (new Pimple())->getApplication();
        });

        return $container;
    }
}

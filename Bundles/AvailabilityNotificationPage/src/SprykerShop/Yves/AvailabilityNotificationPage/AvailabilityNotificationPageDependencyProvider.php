<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AvailabilityNotificationPage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\AvailabilityNotificationPage\Dependency\Client\AvailabilityNotificationPageToAvailabilityNotificationClientBridge;
use SprykerShop\Yves\AvailabilityNotificationPage\Dependency\Client\AvailabilityNotificationPageToCustomerClientBridge;

class AvailabilityNotificationPageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_AVAILABILITY_NOTIFICATION = 'CLIENT_AVAILABILITY_NOTIFICATION';
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addAvailabilityNotificationClient($container);
        $container = $this->addCustomerClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAvailabilityNotificationClient(Container $container): Container
    {
        $container->set(static::CLIENT_AVAILABILITY_NOTIFICATION, function (Container $container) {
            return new AvailabilityNotificationPageToAvailabilityNotificationClientBridge($container->getLocator()->availabilityNotification()->client());
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
            return new AvailabilityNotificationPageToCustomerClientBridge($container->getLocator()->customer()->client());
        });

        return $container;
    }
}

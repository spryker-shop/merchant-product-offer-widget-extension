<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerShop\Yves\WishlistPage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class WishlistPageDependencyProvider extends AbstractBundleDependencyProvider
{
    const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';
    const CLIENT_AVAILABILITY = 'CLIENT_AVAILABILITY';
    const CLIENT_WISHLIST = 'CLIENT_WISHLIST';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addCustomerClient($container);
        $container = $this->addAvailabilityClient($container);
        $container = $this->addWishlistClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[self::CLIENT_CUSTOMER] = function (Container $container) {
            return $container->getLocator()->customer()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAvailabilityClient(Container $container): Container
    {
        $container[self::CLIENT_AVAILABILITY] = function (Container $container) {
            return $container->getLocator()->availability()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addWishlistClient(Container $container): Container
    {
        $container[self::CLIENT_WISHLIST] = function (Container $container) {
            return $container->getLocator()->wishlist()->client();
        };

        return $container;
    }
}

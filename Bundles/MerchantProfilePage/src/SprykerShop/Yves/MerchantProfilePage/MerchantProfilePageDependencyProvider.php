<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\MerchantProfilePage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\MerchantProfilePage\Dependency\Client\MerchantProfilePageToMerchantProfileStorageClientBridge;

class MerchantProfilePageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_MERCHANT_PROFILE_STORAGE = 'CLIENT_MERCHANT_PROFILE_STORAGE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addMerchantProfileStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addMerchantProfileStorageClient(Container $container): Container
    {
        $container[static::CLIENT_MERCHANT_PROFILE_STORAGE] = function (Container $container) {
            return new MerchantProfilePageToMerchantProfileStorageClientBridge($container->getLocator()->merchantProfileStorage()->client());
        };

        return $container;
    }
}

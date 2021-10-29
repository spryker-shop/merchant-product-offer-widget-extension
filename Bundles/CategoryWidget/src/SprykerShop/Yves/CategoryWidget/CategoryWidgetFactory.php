<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CategoryWidget;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\CategoryWidget\Dependency\Client\CategoryWidgetToCategoryStorageClientInterface;
use SprykerShop\Yves\CategoryWidget\Dependency\Client\CategoryWidgetToStoreClientInterface;

class CategoryWidgetFactory extends AbstractFactory
{
    /**
     * @return \SprykerShop\Yves\CategoryWidget\Dependency\Client\CategoryWidgetToCategoryStorageClientInterface
     */
    public function getCategoryStorageClient(): CategoryWidgetToCategoryStorageClientInterface
    {
        return $this->getProvidedDependency(CategoryWidgetDependencyProvider::CLIENT_CATEGORY_STORAGE);
    }

    /**
     * @return \SprykerShop\Yves\CategoryWidget\Dependency\Client\CategoryWidgetToStoreClientInterface
     */
    public function getStoreClient(): CategoryWidgetToStoreClientInterface
    {
        return $this->getProvidedDependency(CategoryWidgetDependencyProvider::CLIENT_STORE);
    }
}

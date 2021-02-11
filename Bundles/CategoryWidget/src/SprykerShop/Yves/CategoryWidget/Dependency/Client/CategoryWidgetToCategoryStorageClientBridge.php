<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CategoryWidget\Dependency\Client;

class CategoryWidgetToCategoryStorageClientBridge implements CategoryWidgetToCategoryStorageClientInterface
{
    /**
     * @var \Spryker\Client\CategoryStorage\CategoryStorageClientInterface
     */
    protected $categoryStorageClient;

    /**
     * @param \Spryker\Client\CategoryStorage\CategoryStorageClientInterface $categoryStorageClient
     */
    public function __construct($categoryStorageClient)
    {
        $this->categoryStorageClient = $categoryStorageClient;
    }

    /**
     * @param string $locale
     * @param string|null $storeName
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer[]|\ArrayObject
     */
    public function getCategories($locale, ?string $storeName = null)
    {
        return $this->categoryStorageClient->getCategories($locale, $storeName);
    }
}

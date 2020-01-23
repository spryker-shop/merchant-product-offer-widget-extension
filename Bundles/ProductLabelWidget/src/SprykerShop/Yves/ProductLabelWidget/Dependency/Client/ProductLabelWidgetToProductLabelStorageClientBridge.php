<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductLabelWidget\Dependency\Client;

class ProductLabelWidgetToProductLabelStorageClientBridge implements ProductLabelWidgetToProductLabelStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductLabelStorage\ProductLabelStorageClientInterface
     */
    protected $productLabelStorageClient;

    /**
     * @param \Spryker\Client\ProductLabelStorage\ProductLabelStorageClientInterface $productLabelStorageClient
     */
    public function __construct($productLabelStorageClient)
    {
        $this->productLabelStorageClient = $productLabelStorageClient;
    }

    /**
     * @param int $idProductAbstract
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductLabelDictionaryItemTransfer[]
     */
    public function findLabelsByIdProductAbstract($idProductAbstract, $localeName)
    {
        return $this->productLabelStorageClient->findLabelsByIdProductAbstract($idProductAbstract, $localeName);
    }

    /**
     * @param array $idProductLabels
     * @param string $localeName
     * @param string|null $storeName
     *
     * @return \Generated\Shared\Transfer\ProductLabelDictionaryItemTransfer[]
     */
    public function findLabels(array $idProductLabels, string $localeName, ?string $storeName = null)
    {
        return $this->productLabelStorageClient->findLabels($idProductLabels, $localeName, $storeName);
    }

    /**
     * @param string $labelName
     * @param string $localeName
     * @param string|null $storeName
     *
     * @return \Generated\Shared\Transfer\ProductLabelDictionaryItemTransfer|null
     */
    public function findLabelByName($labelName, $localeName, ?string $storeName = null)
    {
        return $this->productLabelStorageClient->findLabelByName($labelName, $localeName, $storeName);
    }
}

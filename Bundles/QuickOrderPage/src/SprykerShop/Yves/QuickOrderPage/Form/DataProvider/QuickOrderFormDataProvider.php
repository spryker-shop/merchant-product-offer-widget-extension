<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Form\DataProvider;

use ArrayObject;
use Generated\Shared\Transfer\QuickOrderItemTransfer;
use Generated\Shared\Transfer\QuickOrderTransfer;
use SprykerShop\Yves\QuickOrderPage\Form\QuickOrderItemEmbeddedForm;
use SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig;

class QuickOrderFormDataProvider implements QuickOrderFormDataProviderInterface
{
    /**
     * @var \SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig
     */
    protected $config;

    /**
     * @param \SprykerShop\Yves\QuickOrderPage\QuickOrderPageConfig $config
     */
    public function __construct(QuickOrderPageConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $orderItems
     *
     * @return \Generated\Shared\Transfer\QuickOrderTransfer
     */
    public function getQuickOrderTransfer(array $orderItems = []): QuickOrderTransfer
    {
        $quickOrderTransfer = (new QuickOrderTransfer())
            ->setItems(new ArrayObject($orderItems));

        if (count($orderItems) > 0) {
            return $quickOrderTransfer;
        }

        $this->appendEmptyQuickOrderItems($quickOrderTransfer);

        return $quickOrderTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuickOrderTransfer $quickOrder
     *
     * @return void
     */
    public function appendEmptyQuickOrderItems(QuickOrderTransfer $quickOrder): void
    {
        $itemsNumber = $this->config->getDefaultDisplayedRowCount();

        $quickOrderItemCollection = $quickOrder->getItems();
        for ($i = 0; $i < $itemsNumber; $i++) {
            $quickOrderItemCollection->append(new QuickOrderItemTransfer());
        }
    }

    /**
     * @param array $formDataItems
     *
     * @return \Generated\Shared\Transfer\QuickOrderItemTransfer[]
     */
    public function mapFormDataToQuickOrderItems(array $formDataItems): array
    {
        $quickOrderItems = [];
        foreach ($formDataItems as $formDataItem) {
            $quickOrderItems[] = (new QuickOrderItemTransfer())
                ->setSku(isset($formDataItem[QuickOrderItemEmbeddedForm::FIELD_SKU]) ? $formDataItem[QuickOrderItemEmbeddedForm::FIELD_SKU] : null)
                ->setQuantity(isset($formDataItem[QuickOrderItemEmbeddedForm::FIELD_QUANTITY]) ? (int)$formDataItem[QuickOrderItemEmbeddedForm::FIELD_QUANTITY] : null);
        }

        return $quickOrderItems;
    }
}

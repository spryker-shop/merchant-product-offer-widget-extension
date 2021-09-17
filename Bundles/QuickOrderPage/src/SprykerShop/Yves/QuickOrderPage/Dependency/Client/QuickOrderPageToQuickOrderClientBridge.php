<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Dependency\Client;

use Generated\Shared\Transfer\QuickOrderTransfer;

class QuickOrderPageToQuickOrderClientBridge implements QuickOrderPageToQuickOrderClientInterface
{
    /**
     * @var \Spryker\Client\QuickOrder\QuickOrderClientInterface
     */
    protected $quickOrderClient;

    /**
     * @param \Spryker\Client\QuickOrder\QuickOrderClientInterface $quickOrderClient
     */
    public function __construct($quickOrderClient)
    {
        $this->quickOrderClient = $quickOrderClient;
    }

    /**
     * @param \Generated\Shared\Transfer\QuickOrderTransfer $quickOrderTransfer
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getProductsByQuickOrder(QuickOrderTransfer $quickOrderTransfer): array
    {
        return $this->quickOrderClient->getProductsByQuickOrder($quickOrderTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuickOrderTransfer $quickOrderTransfer
     *
     * @return \Generated\Shared\Transfer\QuickOrderTransfer
     */
    public function buildQuickOrderTransfer(QuickOrderTransfer $quickOrderTransfer): QuickOrderTransfer
    {
        return $this->quickOrderClient->buildQuickOrderTransfer($quickOrderTransfer);
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function expandProductConcreteTransfers(array $productConcreteTransfers): array
    {
        return $this->quickOrderClient->expandProductConcreteTransfers($productConcreteTransfers);
    }
}

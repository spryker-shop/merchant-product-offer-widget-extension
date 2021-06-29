<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPageExtension\Dependency\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;

/**
 * Provides preparation of quote transfer at the address step before grouping.
 */
interface CheckoutAddressStepPreGroupItemsByShipmentPluginInterface
{
    /**
     * Specification:
     * - Prepares quote transfer before grouping.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function preGroupItemsByShipment(QuoteTransfer $quoteTransfer): QuoteTransfer;
}

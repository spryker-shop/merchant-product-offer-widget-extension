<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;

interface CheckoutAddressStepPreCheckPluginInterface
{
    /**
     * Specification:
     * - Decides whether to expose checkout step or not.
     * - Breadcrumb item will not be hidden if at least one plugin returns false.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function isHidden(QuoteTransfer $quoteTransfer): bool;
}

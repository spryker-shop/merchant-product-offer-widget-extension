<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPageExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ItemTransfer;

interface QuickOrderItemTransferExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands provided ItemTransfer with additional data or replaces existing one
     * - Will be executed before adding items into cart
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function expand(ItemTransfer $itemTransfer);
}

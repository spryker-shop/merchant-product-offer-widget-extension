<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartPage\Dependency\Plugin\DiscountWidget;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

/**
 * @deprecated Use molecule('cart-discount-summary', 'DiscountWidget') instead.
 */
interface DiscountSummaryWidgetPluginInterface extends WidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'DiscountSummaryWidgetPlugin';

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function initialize(QuoteTransfer $quoteTransfer): void;
}

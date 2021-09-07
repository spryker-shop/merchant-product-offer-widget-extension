<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartPage\Dependency\Plugin\MultiCartWidget;

use Generated\Shared\Transfer\QuoteTransfer;

/**
 * @deprecated Use {@link \SprykerShop\Yves\MultiCartWidget\Widget\MultiCartListWidget} instead.
 */
interface MultiCartListWidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'MultiCartListWidgetPlugin';

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function initialize(QuoteTransfer $quoteTransfer): void;
}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartPage\Dependency\Plugin\DiscountWidget;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

/**
 * @deprecated Use {@link \SprykerShop\Yves\DiscountWidget\Form\CheckoutVoucherForm} instead
 */
interface DiscountVoucherFormWidgetPluginInterface extends WidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'DiscountVoucherFormWidgetPlugin';

    /**
     * @api
     *
     * @return void
     */
    public function initialize(): void;
}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartPage\Dependency\Plugin\CartToShoppingListWidget;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

/**
 * @deprecated Use {@link \SprykerShop\Yves\ShoppingListWidget\Widget\CreateShoppingListFromCartWidget} instead.
 */
interface CartToShoppingListWidgetPluginInterface extends WidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'CartToShoppingListWidgetPlugin';

    /**
     * @api
     *
     * @param int $idQuote
     *
     * @return void
     */
    public function initialize(int $idQuote): void;
}

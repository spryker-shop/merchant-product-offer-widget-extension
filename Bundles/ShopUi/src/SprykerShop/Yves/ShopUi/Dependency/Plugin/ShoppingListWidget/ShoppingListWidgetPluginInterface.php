<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopUi\Dependency\Plugin\ShoppingListWidget;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

/**
 * @deprecated Use {@link \SprykerShop\Yves\ShoppingListWidget\Widget\ShoppingListNavigationMenuWidget} instead.
 */
interface ShoppingListWidgetPluginInterface extends WidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'ShoppingListWidgetPlugin';

    /**
     * @api
     *
     * @return void
     */
    public function initialize(): void;
}

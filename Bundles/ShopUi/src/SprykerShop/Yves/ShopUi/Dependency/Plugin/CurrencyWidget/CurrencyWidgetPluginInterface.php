<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopUi\Dependency\Plugin\CurrencyWidget;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

/**
 * @deprecated Use \SprykerShop\Yves\CurrencyWidget\Plugin\ShopUi\CurrencyWidget instead.
 */
interface CurrencyWidgetPluginInterface extends WidgetPluginInterface
{
    const NAME = 'CurrencyWidgetPlugin';

    /**
     * @return void
     */
    public function initialize(): void;
}

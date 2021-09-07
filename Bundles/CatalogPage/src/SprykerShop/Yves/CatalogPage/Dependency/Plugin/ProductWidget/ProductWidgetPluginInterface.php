<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage\Dependency\Plugin\ProductWidget;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

/**
 * @deprecated Use {@link \SprykerShop\Yves\ProductWidget\Widget\CatalogPageProductWidget} instead.
 */
interface ProductWidgetPluginInterface extends WidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'ProductWidgetPlugin';

    /**
     * @api
     *
     * @param array $product
     * @param string|null $viewMode
     *
     * @return void
     */
    public function initialize(array $product, $viewMode = null): void;
}

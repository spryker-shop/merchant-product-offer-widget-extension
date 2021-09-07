<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Dependency\Plugin\CustomerPage;

/**
 * @deprecated Use {@link \SprykerShop\Yves\CustomerPage\Widget\CustomerNavigationWidget} instead.
 */
interface CustomerNavigationWidgetPluginInterface
{
    /**
     * @var string
     */
    public const NAME = 'CustomerNavigationWidgetPlugin';

    /**
     * @api
     *
     * @param string $activePage
     * @param int|null $activeEntityId
     *
     * @return void
     */
    public function initialize(string $activePage, ?int $activeEntityId = null): void;
}

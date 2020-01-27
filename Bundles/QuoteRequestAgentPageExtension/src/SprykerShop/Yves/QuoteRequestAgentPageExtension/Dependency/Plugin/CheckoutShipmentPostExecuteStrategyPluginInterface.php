<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestAgentPageExtension\Dependency\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface CheckoutShipmentPostExecuteStrategyPluginInterface
{
    /**
     * Specification:
     *  - Checks if this plugin is applicable for provided quote.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function isApplicable(QuoteTransfer $quoteTransfer): bool;

    /**
     * Specification:
     *  - Performs post execution checkout shipment action.
     *
     * @api
     *
     * @param \Symfony\Cmf\Component\Routing\ChainRouterInterface $router
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(ChainRouterInterface $router): RedirectResponse;
}

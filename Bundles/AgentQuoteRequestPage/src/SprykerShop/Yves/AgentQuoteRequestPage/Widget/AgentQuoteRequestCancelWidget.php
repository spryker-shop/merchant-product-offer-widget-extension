<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AgentQuoteRequestPage\Widget;

use Generated\Shared\Transfer\QuoteRequestTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\AgentQuoteRequestPage\AgentQuoteRequestPageFactory getFactory()
 */
class AgentQuoteRequestCancelWidget extends AbstractWidget
{
    /**
     * @param \Generated\Shared\Transfer\QuoteRequestTransfer $quoteRequestTransfer
     */
    public function __construct(QuoteRequestTransfer $quoteRequestTransfer)
    {
        $this->addQuoteRequestParameter($quoteRequestTransfer);
        $this->addIsQuoteRequestCancelableParameter($quoteRequestTransfer);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'AgentQuoteRequestCancelWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@AgentQuoteRequestPage/views/quote-request-cancel-link/quote-request-cancel-link.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteRequestTransfer $quoteRequestTransfer
     *
     * @return void
     */
    protected function addQuoteRequestParameter(QuoteRequestTransfer $quoteRequestTransfer): void
    {
        $this->addParameter('quoteRequest', $quoteRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteRequestTransfer $quoteRequestTransfer
     *
     * @return void
     */
    protected function addIsQuoteRequestCancelableParameter(QuoteRequestTransfer $quoteRequestTransfer): void
    {
        $isQuoteRequestCancelable = $this->getFactory()
            ->getAgentQuoteRequestClient()
            ->isQuoteRequestCancelable($quoteRequestTransfer);

        $this->addParameter('isQuoteRequestCancelable', $isQuoteRequestCancelable);
    }
}

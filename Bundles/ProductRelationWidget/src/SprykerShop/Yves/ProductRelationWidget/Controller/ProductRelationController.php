<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductRelationWidget\Controller;

use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\ProductRelationWidget\ProductRelationWidgetFactory getFactory()
 */
class ProductRelationController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function getUpsellingProductsWidgetAjaxAction(Request $request): View
    {
        return $this->executeGetUpsellingProductsWidgetAjaxAction();
    }

    /**
     * @return \Spryker\Yves\Kernel\View\View
     */
    protected function executeGetUpsellingProductsWidgetAjaxAction(): View
    {
        $viewData = [
            'cart' => $this->getFactory()->getCartClient()->getQuote(),
        ];

        return $this->view($viewData, [], '@ProductRelationWidget/views/ajax-upselling-widget/ajax-upselling-widget.twig');
    }
}

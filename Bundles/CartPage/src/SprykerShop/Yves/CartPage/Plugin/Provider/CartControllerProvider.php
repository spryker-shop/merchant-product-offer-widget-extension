<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartPage\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * @deprecated Use `\SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin` instead.
 */
class CartControllerProvider extends AbstractYvesControllerProvider
{
    public const ROUTE_CART = 'cart';
    public const ROUTE_CART_ADD = 'cart/add';
    public const ROUTE_CART_QUICK_ADD = 'cart/quick-add';
    public const ROUTE_CART_REMOVE = 'cart/remove';
    public const ROUTE_CART_CHANGE = 'cart/change';
    public const ROUTE_CART_UPDATE = 'cart/update';
    public const ROUTE_CART_CHANGE_QUANTITY = 'cart/change/quantity';
    public const ROUTE_CART_ADD_ITEMS = 'cart/add-items';
    public const SKU_PATTERN = '[a-zA-Z0-9-_\.]+';

    protected const ROUTE_CART_RESET_LOCK = 'cart/reset-lock';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->addCartRoute()
            ->addCartAddItemsRoute()
            ->addCartAddRoute()
            ->addCartRemoveRoute()
            ->addCartChangeQuantityRoute()
            ->addCartUpdateRoute()
            ->addCartQuickAddRoute()
            ->addCartResetLockRoute();
    }

    /**
     * @return $this
     */
    protected function addCartRoute()
    {
        $this->createController('/{cart}', self::ROUTE_CART, 'CartPage', 'Cart')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart')
            ->convert('selectedAttributes', [$this, 'getSelectedAttributesFromRequest']);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addCartAddItemsRoute()
    {
        $this->createPostController('/{cart}/add-items', self::ROUTE_CART_ADD_ITEMS, 'CartPage', 'Cart', 'addItems')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart');

        return $this;
    }

    /**
     * @uses \SprykerShop\Yves\CartPage\Controller\CartLockController::resetLockAction()
     *
     * @return $this
     */
    protected function addCartResetLockRoute()
    {
        $this->createPostController('/{cart}/reset-lock', static::ROUTE_CART_RESET_LOCK, 'CartPage', 'CartLock', 'resetLock')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart');

        return $this;
    }

    /**
     * @return $this
     */
    protected function addCartAddRoute()
    {
        $this->createController('/{cart}/add/{sku}', self::ROUTE_CART_ADD, 'CartPage', 'Cart', 'add')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart')
            ->assert('sku', self::SKU_PATTERN)
            ->convert('quantity', [$this, 'getQuantityFromRequest'])
            ->convert('optionValueIds', [$this, 'getProductOptionsFromRequest']);

        return $this;
    }

    /**
     * @uses CartControllerProvider::getQuantityFromRequest()
     * @uses CartController::quickAddAction()
     *
     * @return $this
     */
    protected function addCartQuickAddRoute()
    {
        $this->createController('/{cart}/quick-add/{sku}', static::ROUTE_CART_QUICK_ADD, 'CartPage', 'Cart', 'quickAdd')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart')
            ->assert('sku', static::SKU_PATTERN)
            ->convert('quantity', [$this, 'getQuantityFromRequest']);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addCartRemoveRoute()
    {
        $this->createController('/{cart}/remove/{sku}/{groupKey}', self::ROUTE_CART_REMOVE, 'CartPage', 'Cart', 'remove')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart')
            ->assert('sku', self::SKU_PATTERN)
            ->value('groupKey', '');

        return $this;
    }

    /**
     * @return $this
     */
    protected function addCartChangeQuantityRoute()
    {
        $this->createController('/{cart}/change/{sku}', self::ROUTE_CART_CHANGE_QUANTITY, 'CartPage', 'Cart', 'change')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart')
            ->assert('sku', self::SKU_PATTERN)
            ->convert('quantity', [$this, 'getQuantityFromRequest'])
            ->convert('groupKey', [$this, 'getGroupKeyFromRequest'])
            ->method('POST');

        return $this;
    }

    /**
     * @return $this
     */
    protected function addCartUpdateRoute()
    {
        $this->createController('/{cart}/update/{sku}', self::ROUTE_CART_UPDATE, 'CartPage', 'Cart', 'update')
            ->assert('cart', $this->getAllowedLocalesPattern() . 'cart|cart')
            ->value('cart', 'cart')
            ->assert('sku', self::SKU_PATTERN)
            ->convert('quantity', [$this, 'getQuantityFromRequest'])
            ->convert('groupKey', [$this, 'getGroupKeyFromRequest'])
            ->convert('selectedAttributes', [$this, 'getSelectedAttributesFromRequest'])
            ->convert('preselectedAttributes', [$this, 'getPreSelectedAttributesFromRequest'])
            ->convert('optionValueIds', [$this, 'getProductOptionsFromRequest'])
            ->method('POST');

        return $this;
    }

    /**
     * @param mixed $unusedParameter
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int
     */
    public function getQuantityFromRequest($unusedParameter, Request $request)
    {
        if ($request->isMethod('POST')) {
            return $request->request->getInt('quantity', 1);
        }

        return $request->query->getInt('quantity', 1);
    }

    /**
     * @param mixed $unusedParameter
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int
     */
    public function getSelectedAttributesFromRequest($unusedParameter, Request $request)
    {
        if ($request->isMethod('POST')) {
            return $request->request->get('selectedAttributes', []);
        }

        return $request->query->get('selectedAttributes', []);
    }

    /**
     * @param mixed $unusedParameter
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int
     */
    public function getPreSelectedAttributesFromRequest($unusedParameter, Request $request)
    {
        if ($request->isMethod('POST')) {
            return $request->request->get('preselectedAttributes', []);
        }

        return $request->query->get('preselectedAttributes', []);
    }

    /**
     * @param mixed $unusedParameter
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int
     */
    public function getProductOptionsFromRequest($unusedParameter, Request $request)
    {
        if ($request->isMethod('POST')) {
            return $request->request->get('product-option', []);
        }

        return $request->query->get('product-option', []);
    }

    /**
     * @param mixed $unusedParameter
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int
     */
    public function getGroupKeyFromRequest($unusedParameter, Request $request)
    {
        if ($request->isMethod('POST')) {
            return $request->request->get('groupKey');
        }

        return $request->query->get('groupKey');
    }
}

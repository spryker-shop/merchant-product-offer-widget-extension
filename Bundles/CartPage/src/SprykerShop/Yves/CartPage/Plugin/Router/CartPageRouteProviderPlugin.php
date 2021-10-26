<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CartPage\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

class CartPageRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART} instead.
     *
     * @var string
     */
    protected const ROUTE_CART = 'cart';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART = 'cart';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_ADD} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_ADD = 'cart/add';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_ADD = 'cart/add';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_ADD_AJAX} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_ADD_AJAX = 'cart/add-ajax';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_ADD_AJAX = 'cart/add-ajax';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_QUICK_ADD} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_QUICK_ADD = 'cart/quick-add';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_QUICK_ADD = 'cart/quick-add';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_REMOVE} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_REMOVE = 'cart/remove';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_REMOVE = 'cart/remove';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_CHANGE} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_CHANGE = 'cart/change';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_CHANGE = 'cart/change';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_UPDATE} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_UPDATE = 'cart/update';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_UPDATE = 'cart/update';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_CHANGE_QUANTITY} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_CHANGE_QUANTITY = 'cart/change/quantity';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_CHANGE_QUANTITY = 'cart/change/quantity';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_ADD_ITEMS} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_ADD_ITEMS = 'cart/add-items';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_ADD_ITEMS = 'cart/add-items';

    /**
     * @var string
     */
    protected const SKU_PATTERN = '[a-zA-Z0-9-_\.]+';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART_RESET_LOCK} instead.
     *
     * @var string
     */
    protected const ROUTE_CART_RESET_LOCK = 'cart/reset-lock';

    /**
     * @var string
     */
    public const ROUTE_NAME_CART_RESET_LOCK = 'cart/reset-lock';

    /**
     * @var string
     */
    public const ROUTE_NAME_GET_UPSELLING_WIDGET_AJAX = 'cart/get-upselling-widget';

    /**
     * @var string
     */
    public const ROUTE_NAME_GET_CART_ITEMS_AJAX = 'cart/get-cart-items';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addCartRoute($routeCollection);
        $routeCollection = $this->addCartAddItemsRoute($routeCollection);
        $routeCollection = $this->addCartAddRoute($routeCollection);
        $routeCollection = $this->addCartAddAjaxRoute($routeCollection);
        $routeCollection = $this->addCartRemoveRoute($routeCollection);
        $routeCollection = $this->addCartChangeQuantityRoute($routeCollection);
        $routeCollection = $this->addCartUpdateRoute($routeCollection);
        $routeCollection = $this->addCartQuickAddRoute($routeCollection);
        $routeCollection = $this->addCartResetLockRoute($routeCollection);
        $routeCollection = $this->addGetUpsellingWidgetAjaxRoute($routeCollection);
        $routeCollection = $this->addCartItemsAjaxRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart', 'CartPage', 'Cart', 'indexAction');
        $routeCollection->add(static::ROUTE_NAME_CART, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\CartPage\Controller\CartController::getCartItemsAjaxAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartItemsAjaxRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/get-cart-items', 'CartPage', 'Cart', 'getCartItemsAjaxAction');

        $route = $route->setMethods(Request::METHOD_GET);
        $routeCollection->add(static::ROUTE_NAME_GET_CART_ITEMS_AJAX, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartAddItemsRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/add-items', 'CartPage', 'Cart', 'addItemsAction');
        $route = $route->setMethods(Request::METHOD_POST);
        $routeCollection->add(static::ROUTE_NAME_CART_ADD_ITEMS, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\CartPage\Controller\CartLockController::resetLockAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartResetLockRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/reset-lock', 'CartPage', 'CartLock', 'resetLockAction');
        $routeCollection->add(static::ROUTE_NAME_CART_RESET_LOCK, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartAddRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/add/{sku}', 'CartPage', 'Cart', 'addAction');
        $route = $route->setRequirement('sku', static::SKU_PATTERN);
        $route = $route->setMethods(Request::METHOD_POST);
        $routeCollection->add(static::ROUTE_NAME_CART_ADD, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\CartPage\Controller\CartController::addAjaxAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartAddAjaxRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/add-ajax/{sku}', 'CartPage', 'Cart', 'addAjaxAction');
        $route = $route->setRequirement('sku', static::SKU_PATTERN);
        $route = $route->setMethods(Request::METHOD_POST);
        $routeCollection->add(static::ROUTE_NAME_CART_ADD_AJAX, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\CartPage\Controller\CartController::quickAddAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartQuickAddRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/quick-add/{sku}', 'CartPage', 'Cart', 'quickAddAction');
        $route = $route->setRequirement('sku', static::SKU_PATTERN);
        $routeCollection->add(static::ROUTE_NAME_CART_QUICK_ADD, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartRemoveRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/remove/{sku}/{groupKey}', 'CartPage', 'Cart', 'removeAction');
        $route = $route->setRequirement('sku', static::SKU_PATTERN);
        $route = $route->setDefault('groupKey', '');
        $route = $route->setMethods(Request::METHOD_POST);

        $routeCollection->add(static::ROUTE_NAME_CART_REMOVE, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartChangeQuantityRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/change/{sku}', 'CartPage', 'Cart', 'changeAction');
        $route = $route->setRequirement('sku', static::SKU_PATTERN);
        $route = $route->setMethods(Request::METHOD_POST);
        $routeCollection->add(static::ROUTE_NAME_CART_CHANGE_QUANTITY, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addCartUpdateRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/update/{sku}', 'CartPage', 'Cart', 'updateAction');
        $route = $route->setRequirement('sku', static::SKU_PATTERN);
        $route = $route->setMethods(Request::METHOD_POST);
        $routeCollection->add(static::ROUTE_NAME_CART_UPDATE, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\CartPage\Controller\CartController::getUpsellingProductsWidgetAjaxAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addGetUpsellingWidgetAjaxRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/cart/get-upselling-widget', 'CartPage', 'Cart', 'getUpsellingProductsWidgetAjaxAction');
        $route = $route->setMethods(Request::METHOD_GET);
        $routeCollection->add(static::ROUTE_NAME_GET_UPSELLING_WIDGET_AJAX, $route);

        return $routeCollection;
    }
}

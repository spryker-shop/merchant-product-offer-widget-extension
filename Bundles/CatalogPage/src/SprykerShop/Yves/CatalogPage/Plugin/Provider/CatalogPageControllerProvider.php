<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

/**
 * @deprecated Use {@link \SprykerShop\Yves\CatalogPage\Plugin\Router\CatalogPageRouteProviderPlugin} instead.
 */
class CatalogPageControllerProvider extends AbstractYvesControllerProvider
{
    /**
     * @var string
     */
    public const ROUTE_SEARCH = 'search';

    /**
     * @var string
     */
    public const ROUTE_SUGGESTION = 'search/suggestion';

    /**
     * @var string
     */
    public const ROUTER_CHANGE_VIEW_MODE = 'change-view-mode';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->addFulltextSearchRoute()
            ->addSuggestionRoute()
            ->addChangeViewRoute();
    }

    /**
     * @return $this
     */
    protected function addFulltextSearchRoute()
    {
        $this->createController('/{search}', static::ROUTE_SEARCH, 'CatalogPage', 'Catalog', 'fulltextSearch')
            ->assert('search', $this->getAllowedLocalesPattern() . 'search|search')
            ->value('search', 'search');

        return $this;
    }

    /**
     * @return $this
     */
    protected function addSuggestionRoute()
    {
        $this->createController('/{search}/suggestion', static::ROUTE_SUGGESTION, 'CatalogPage', 'Suggestion', 'index')
            ->assert('search', $this->getAllowedLocalesPattern() . 'search|search')
            ->value('search', 'search');

        return $this;
    }

    /**
     * @return $this
     */
    protected function addChangeViewRoute()
    {
        $this->createController('/{catalog}/change-view-mode', static::ROUTER_CHANGE_VIEW_MODE, 'CatalogPage', 'Catalog', 'changeViewMode')
            ->assert('catalog', $this->getAllowedLocalesPattern() . 'catalog|catalog')
            ->value('catalog', 'catalog');

        return $this;
    }
}

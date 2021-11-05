<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ErrorPage\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

/**
 * @deprecated Use {@link \SprykerShop\Yves\ErrorPage\Plugin\Router\ErrorPageRouteProviderPlugin} instead.
 */
class ErrorPageControllerProvider extends AbstractYvesControllerProvider
{
    /**
     * @var string
     */
    public const ROUTE_ERROR_404 = 'error/404';

    /**
     * @var string
     */
    public const ROUTE_ERROR_404_PATH = '/error/404';

    /**
     * @var string
     */
    protected const ROUTE_ERROR_403 = 'error/403';

    /**
     * @var string
     */
    protected const ROUTE_ERROR_403_PATH = '/error/403';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app): void
    {
        $this->addError404Route()
            ->addError403Route();
    }

    /**
     * @uses \SprykerShop\Yves\ErrorPage\Controller\Error404Controller::indexAction()
     *
     * @return $this
     */
    protected function addError404Route()
    {
        $this->createController(static::ROUTE_ERROR_404_PATH, static::ROUTE_ERROR_404, 'ErrorPage', 'Error404');

        return $this;
    }

    /**
     * @uses \SprykerShop\Yves\ErrorPage\Controller\Error403Controller::indexAction()
     *
     * @return $this
     */
    protected function addError403Route()
    {
        $this->createController(static::ROUTE_ERROR_403_PATH, static::ROUTE_ERROR_403, 'ErrorPage', 'Error403');

        return $this;
    }
}

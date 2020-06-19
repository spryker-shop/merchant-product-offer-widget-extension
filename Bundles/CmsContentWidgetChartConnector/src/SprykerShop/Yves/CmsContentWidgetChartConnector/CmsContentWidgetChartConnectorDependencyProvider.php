<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CmsContentWidgetChartConnector;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class CmsContentWidgetChartConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const PLUGIN_CMS_CHART_CONTENT_WIDGETS = 'PLUGIN_CMS_CHART_CONTENT_WIDGETS';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addCmsChartContentWidgetPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCmsChartContentWidgetPlugins(Container $container): Container
    {
        $container->set(static::PLUGIN_CMS_CHART_CONTENT_WIDGETS, function () {
            return $this->getCmsChartContentWidgetPlugins();
        });

        return $container;
    }

    /**
     * @return string[]
     */
    protected function getCmsChartContentWidgetPlugins(): array
    {
        return [];
    }
}

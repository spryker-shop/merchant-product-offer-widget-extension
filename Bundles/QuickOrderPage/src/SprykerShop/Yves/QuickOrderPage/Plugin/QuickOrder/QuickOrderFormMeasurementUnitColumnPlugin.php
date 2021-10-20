<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\Plugin\QuickOrder;

use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\QuickOrderPageExtension\Dependency\Plugin\QuickOrderFormColumnPluginInterface;

class QuickOrderFormMeasurementUnitColumnPlugin extends AbstractPlugin implements QuickOrderFormColumnPluginInterface
{
    /**
     * @var string
     */
    protected const COLUMN_TITLE = 'quick-order.input-label.measurement_unit';

    /**
     * @var string
     */
    protected const DATA_PATH = 'baseMeasurementUnit.name';

    /**
     * @return string
     */
    public function getColumnTitle(): string
    {
        return static::COLUMN_TITLE;
    }

    /**
     * @return string
     */
    public function getDataPath(): string
    {
        return static::DATA_PATH;
    }
}

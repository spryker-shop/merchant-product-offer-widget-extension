<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductBundleWidget\Expander;

interface SalesReturnPageFormExpanderInterface
{
    /**
     * @param array $formData
     *
     * @return array
     */
    public function expandFormData(array $formData): array;
}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Form\Transformer;

use SprykerShop\Yves\CustomerPage\Form\CheckoutAddressForm;
use Symfony\Component\Form\DataTransformerInterface;

class AddressSelectTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function transform($value): ?string
    {
        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return int|null
     */
    public function reverseTransform($value): ?int
    {
        if (!$value) {
            return CheckoutAddressForm::VALUE_NEW_ADDRESS_IS_EMPTY;
        }

        return (int)$value;
    }
}

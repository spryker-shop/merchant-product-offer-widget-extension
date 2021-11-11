<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\DiscountPromotionWidget\Dependency\Service;

use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountCalculationResponseTransfer;

class DiscountPromotionWidgetToDiscountServiceBridge implements DiscountPromotionWidgetToDiscountServiceInterface
{
    /**
     * @var \Spryker\Service\Discount\DiscountServiceInterface
     */
    protected $discountService;

    /**
     * @param \Spryker\Service\Discount\DiscountServiceInterface $discountService
     */
    public function __construct($discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * @deprecated Please do not use this method. Exists only for internal purposes.
     *
     * @param \Generated\Shared\Transfer\DiscountCalculationRequestTransfer $discountCalculationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountCalculationResponseTransfer
     */
    public function calculate(DiscountCalculationRequestTransfer $discountCalculationRequestTransfer): DiscountCalculationResponseTransfer
    {
        return $this->discountService->calculate($discountCalculationRequestTransfer);
    }
}

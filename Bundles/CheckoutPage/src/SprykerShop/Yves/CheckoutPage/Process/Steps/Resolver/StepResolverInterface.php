<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CheckoutPage\Process\Steps\Resolver;

use Spryker\Yves\StepEngine\Process\StepCollectionInterface;

interface StepResolverInterface
{
    /**
     * @return \Spryker\Yves\StepEngine\Process\StepCollectionInterface
     */
    public function resolveSteps(): StepCollectionInterface;
}

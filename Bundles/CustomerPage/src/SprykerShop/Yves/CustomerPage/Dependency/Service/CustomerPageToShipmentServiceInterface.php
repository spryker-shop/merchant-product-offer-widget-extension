<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Dependency\Service;

use ArrayObject;

interface CustomerPageToShipmentServiceInterface
{
    /**
     * @param iterable<\Generated\Shared\Transfer\ItemTransfer> $itemTransferCollection
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\ShipmentGroupTransfer>
     */
    public function groupItemsByShipment(iterable $itemTransferCollection): ArrayObject;
}

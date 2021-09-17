<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductOptionWidget\Form\DataProvider;

use ArrayObject;
use Generated\Shared\Transfer\ShoppingListItemTransfer;

interface ShoppingListItemProductOptionFormDataProviderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\ProductOptionGroupStorageTransfer>
     */
    public function findProductOptionGroupsByShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ArrayObject;
}

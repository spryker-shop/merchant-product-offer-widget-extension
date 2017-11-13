<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\MoneyWidget\Mapper;

use Money\Money;
use Spryker\Shared\Money\Mapper\MoneyToTransferMapper as SharedMoneyToTransferMapper;
use SprykerShop\Yves\CurrencyWidget\Plugin\CurrencyPluginInterface;

class MoneyToTransferMapper extends SharedMoneyToTransferMapper
{
    /**
     * @var \SprykerShop\Yves\CurrencyWidget\Plugin\CurrencyPlugin
     */
    protected $currencyPlugin;

    /**
     * @param \SprykerShop\Yves\CurrencyWidget\Plugin\CurrencyPluginInterface $currencyPlugin
     */
    public function __construct(CurrencyPluginInterface $currencyPlugin)
    {
        $this->currencyPlugin = $currencyPlugin;
    }

    /**
     * @param \Money\Money $money
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    protected function getCurrencyTransfer(Money $money)
    {
        return $this->currencyPlugin->fromIsoCode($money->getCurrency()->getCode());
    }
}

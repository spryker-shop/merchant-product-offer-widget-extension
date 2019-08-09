<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ConfigurableBundleWidget\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ConfiguredBundleCollectionTransfer;
use Generated\Shared\Transfer\ConfiguredBundleTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerShop\Yves\ConfigurableBundleWidget\Calculator\ConfiguredBundlePriceCalculatorInterface;

class ConfiguredBundleMapper implements ConfiguredBundleMapperInterface
{
    /**
     * @var \SprykerShop\Yves\ConfigurableBundleWidget\Calculator\ConfiguredBundlePriceCalculatorInterface
     */
    protected $configuredBundlePriceCalculator;

    /**
     * @param \SprykerShop\Yves\ConfigurableBundleWidget\Calculator\ConfiguredBundlePriceCalculatorInterface $configuredBundlePriceCalculator
     */
    public function __construct(ConfiguredBundlePriceCalculatorInterface $configuredBundlePriceCalculator)
    {
        $this->configuredBundlePriceCalculator = $configuredBundlePriceCalculator;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ConfiguredBundleCollectionTransfer
     */
    public function mapQuoteToConfiguredBundles(QuoteTransfer $quoteTransfer): ConfiguredBundleCollectionTransfer
    {
        $configuredBundleTransfers = [];

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            if ($itemTransfer->getConfiguredBundleItem() && $itemTransfer->getConfiguredBundle()) {
                $configuredBundleTransfers = $this->mapConfiguredBundle($itemTransfer, $configuredBundleTransfers);
            }
        }

        $configuredBundleTransfers = $this->expandConfiguredBundlesWithPrices($configuredBundleTransfers);

        return (new ConfiguredBundleCollectionTransfer())
            ->setConfiguredBundles(new ArrayObject(array_values($configuredBundleTransfers)));
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\ConfiguredBundleTransfer[] $configuredBundleTransfers
     *
     * @return \Generated\Shared\Transfer\ConfiguredBundleTransfer[]
     */
    protected function mapConfiguredBundle(ItemTransfer $itemTransfer, array $configuredBundleTransfers): array
    {
        $configuredBundleItemTransfer = $itemTransfer->getConfiguredBundleItem();
        $configuredBundleTransfer = $itemTransfer->getConfiguredBundle();

        $configuredBundleItemTransfer
            ->requireSlot()
            ->getSlot()
                ->requireUuid();

        $configuredBundleTransfer
            ->requireGroupKey()
            ->requireQuantity()
            ->requireTemplate()
            ->getTemplate()
                ->requireUuid()
                ->requireName();

        if (!isset($configuredBundleTransfers[$configuredBundleTransfer->getGroupKey()])) {
            $configuredBundleTransfers[$configuredBundleTransfer->getGroupKey()] = (new ConfiguredBundleTransfer())
                ->fromArray($configuredBundleTransfer->toArray());
        }

        $configuredBundleTransfers[$configuredBundleTransfer->getGroupKey()]->addItem($itemTransfer);

        return $configuredBundleTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\ConfiguredBundleTransfer[] $configuredBundleTransfers
     *
     * @return \Generated\Shared\Transfer\ConfiguredBundleTransfer[]
     */
    protected function expandConfiguredBundlesWithPrices(array $configuredBundleTransfers): array
    {
        foreach ($configuredBundleTransfers as $configuredBundleTransfer) {
            $configuredBundleTransfer->setPrice(
                $this->configuredBundlePriceCalculator->calculateConfiguredBundlePrice($configuredBundleTransfer)
            );
        }

        return $configuredBundleTransfers;
    }
}

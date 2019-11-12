<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ConfigurableBundleCartNoteWidget\Form\DataProvider;

use Generated\Shared\Transfer\ConfiguredBundleCartNoteRequestTransfer;
use Generated\Shared\Transfer\ConfiguredBundleTransfer;

class ConfigurableBundleCartNoteFormDataProvider
{
    /**
     * @param \Generated\Shared\Transfer\ConfiguredBundleTransfer|null $configuredBundleTransfer
     *
     * @return \Generated\Shared\Transfer\ConfiguredBundleCartNoteRequestTransfer
     */
    public function getData(?ConfiguredBundleTransfer $configuredBundleTransfer = null): ConfiguredBundleCartNoteRequestTransfer
    {
        if (!$configuredBundleTransfer) {
            return new ConfiguredBundleCartNoteRequestTransfer();
        }

        return (new ConfiguredBundleCartNoteRequestTransfer())
            ->setGroupKey($configuredBundleTransfer->getGroupKey())
            ->setTemplateName($configuredBundleTransfer->getTemplate()->getName())
            ->setCartNote($configuredBundleTransfer->getCartNote());
    }
}

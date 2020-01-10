<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CmsSlotBlockWidget\Dependency\Client;

use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;

class CmsSlotBlockWidgetToCmsSlotBlockStorageClientBridge implements CmsSlotBlockWidgetToCmsSlotBlockStorageClientInterface
{
    /**
     * @var \Spryker\Client\CmsSlotBlockStorage\CmsSlotBlockStorageClientInterface
     */
    protected $cmsSlotBlockStorageClient;

    /**
     * @param \Spryker\Client\CmsSlotBlockStorage\CmsSlotBlockStorageClientInterface $cmsSlotBlockStorageClient
     */
    public function __construct($cmsSlotBlockStorageClient)
    {
        $this->cmsSlotBlockStorageClient = $cmsSlotBlockStorageClient;
    }

    /**
     * @param string $cmsSlotTemplatePath
     * @param string $cmsSlotKey
     *
     * @return \Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer
     */
    public function getCmsSlotBlockCollection(
        string $cmsSlotTemplatePath,
        string $cmsSlotKey
    ): CmsSlotBlockCollectionTransfer {
        return $this->cmsSlotBlockStorageClient
            ->getCmsSlotBlockCollection($cmsSlotTemplatePath, $cmsSlotKey);
    }
}

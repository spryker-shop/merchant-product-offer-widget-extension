<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Model\Reader;

use Iterator;

interface InvitationReaderInterface
{
    /**
     * @param string $importFilePath
     *
     * @return string[]
     */
    public function getHeaders(string $importFilePath);

    /**
     * @param string $importFilePath
     *
     * @return \Iterator
     */
    public function getData(string $importFilePath): Iterator;
}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AgentPage\Formatter;

interface LoginCheckUrlFormatterInterface
{
    /**
     * @return string
     */
    public function getLoginCheckPath(): string;
}

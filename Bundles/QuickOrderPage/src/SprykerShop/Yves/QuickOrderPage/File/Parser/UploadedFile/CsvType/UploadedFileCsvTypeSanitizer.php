<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\CsvType;

use SprykerShop\Yves\QuickOrderPage\File\Parser\UploadedFile\UploadedFileCsvTypeSanitizerInterface;

class UploadedFileCsvTypeSanitizer implements UploadedFileCsvTypeSanitizerInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function sanitizeQuantity($value)
    {
        if (!$value || $value < 1) {
            return 1;
        }

        return $value;
    }
}

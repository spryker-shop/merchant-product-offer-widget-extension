<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ErrorPage;

use Spryker\Yves\Kernel\AbstractBundleConfig;
use SprykerShop\Shared\ErrorPage\ErrorPageConstants;
use Symfony\Component\HttpFoundation\Response;

class ErrorPageConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return array<int>
     */
    public function getValidSubRequestExceptionStatusCodes()
    {
        return [
            Response::HTTP_NOT_FOUND,
            Response::HTTP_FORBIDDEN,
            Response::HTTP_TOO_MANY_REQUESTS,
        ];
    }

    /**
     * @api
     *
     * @return array<int>
     */
    public function getValidRedirectExceptionStatusCodes(): array
    {
        return [
            Response::HTTP_NOT_FOUND,
            Response::HTTP_FORBIDDEN,
        ];
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isErrorStackTraceEnabled(): bool
    {
        return $this->get(ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE, $this->getErrorStackTraceDefaultValue());
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return bool
     */
    protected function getErrorStackTraceDefaultValue(): bool
    {
        return APPLICATION_ENV === 'development';
    }
}

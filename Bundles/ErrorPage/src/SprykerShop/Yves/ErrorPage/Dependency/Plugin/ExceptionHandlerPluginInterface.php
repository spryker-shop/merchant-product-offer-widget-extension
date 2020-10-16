<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ErrorPage\Dependency\Plugin;

use Symfony\Component\ErrorHandler\Exception\FlattenException;

interface ExceptionHandlerPluginInterface
{
    /**
     * @api
     *
     * @param int $statusCode
     *
     * @return bool
     */
    public function canHandle($statusCode);

    /**
     * @api
     *
     * @param \Symfony\Component\ErrorHandler\Exception\FlattenException $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleException(FlattenException $exception);
}

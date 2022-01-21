<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage\Dependency\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface CatalogPageToCatalogClientInterface
{
    /**
     * @param string $searchString
     * @param array<mixed> $requestParameters
     *
     * @return array<mixed>
     */
    public function catalogSearch($searchString, array $requestParameters);

    /**
     * @param string $searchString
     * @param array<string, mixed> $requestParameters
     *
     * @return array<string, mixed>
     */
    public function catalogSuggestSearch($searchString, array $requestParameters = []);

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string
     */
    public function getCatalogViewMode(Request $request);

    /**
     * @param string $mode
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setCatalogViewMode($mode, Response $response);

    /**
     * @param string $searchString
     * @param array<mixed> $requestParameters
     *
     * @return int
     */
    public function catalogSearchCount(string $searchString, array $requestParameters): int;
}

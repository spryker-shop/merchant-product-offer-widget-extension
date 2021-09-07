<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Form\DataProvider;

use Spryker\Shared\Kernel\Store;
use SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface;

abstract class AbstractAddressFormDataProvider
{
    /**
     * @var string
     */
    public const COUNTRY_GLOSSARY_PREFIX = 'countries.iso.';

    /**
     * @var \SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface
     */
    protected $customerClient;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @param \SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface $customerClient
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(CustomerPageToCustomerClientInterface $customerClient, Store $store)
    {
        $this->customerClient = $customerClient;
        $this->store = $store;
    }

    /**
     * @return array
     */
    protected function getAvailableCountries()
    {
        $countries = [];

        foreach ($this->store->getCountries() as $iso2Code) {
            $countries[$iso2Code] = self::COUNTRY_GLOSSARY_PREFIX . $iso2Code;
        }

        return $countries;
    }
}

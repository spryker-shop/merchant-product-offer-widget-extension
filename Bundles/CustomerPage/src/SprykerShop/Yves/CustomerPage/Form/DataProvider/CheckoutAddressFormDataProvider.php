<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Form\DataProvider;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface;
use SprykerShop\Yves\CustomerPage\Form\CheckoutAddressCollectionForm;

class CheckoutAddressFormDataProvider extends AbstractAddressFormDataProvider implements StepEngineFormDataProviderInterface
{
    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransfer;

    /**
     * @param \SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface $customerClient
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(CustomerPageToCustomerClientInterface $customerClient, Store $store)
    {
        parent::__construct($customerClient, $store);

        $this->customerTransfer = $this->getCustomer();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        $quoteTransfer->setShippingAddress($this->getShippingAddress($quoteTransfer));
        $quoteTransfer->setBillingAddress($this->getBillingAddress($quoteTransfer));

        $quoteTransfer->setBillingSameAsShipping(
            $this->isSameAddress($quoteTransfer->getShippingAddress(), $quoteTransfer->getBillingAddress())
        );

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [
            CheckoutAddressCollectionForm::OPTION_ADDRESS_CHOICES => $this->getAddressChoices(),
            CheckoutAddressCollectionForm::OPTION_COUNTRY_CHOICES => $this->getAvailableCountries(),
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomer()
    {
        $this->customerClient->markCustomerAsDirty();

        return $this->customerClient->getCustomer();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function getShippingAddress(QuoteTransfer $quoteTransfer): AddressTransfer
    {
        $addressTransfer = new AddressTransfer();
        if ($this->isShippingAddressInQuote($quoteTransfer)) {
            $addressTransfer = $quoteTransfer->getShippingAddress();
        }

        if ($this->customerTransfer !== null) {
            $addressTransfer->setIdCustomerAddress($this->customerTransfer->getDefaultShippingAddress());
        }

        return $addressTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isShippingAddressInQuote(QuoteTransfer $quoteTransfer): bool
    {
        if ($quoteTransfer->getShippingAddress() === null) {
            return false;
        }

        if ($this->isEmptyAddress($quoteTransfer->getShippingAddress())) {
            return false;
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function getBillingAddress(QuoteTransfer $quoteTransfer): AddressTransfer
    {
        $addressTransfer = new AddressTransfer();
        if ($this->isBillingAddressInQuote($quoteTransfer)) {
            $addressTransfer = $quoteTransfer->getBillingAddress();
        }

        if ($this->customerTransfer !== null) {
            $addressTransfer->setIdCustomerAddress($this->customerTransfer->getDefaultBillingAddress());
        }

        return $addressTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isBillingAddressInQuote(QuoteTransfer $quoteTransfer): bool
    {
        if ($quoteTransfer->getBillingAddress() === null) {
            return false;
        }

        if ($this->isEmptyAddress($quoteTransfer->getBillingAddress())) {
            return false;
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return bool
     */
    protected function isEmptyAddress(AddressTransfer $addressTransfer): bool
    {
        return !array_filter($addressTransfer->toArray());
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $shippingAddressTransfer
     * @param \Generated\Shared\Transfer\AddressTransfer $billingAddressTransfer
     *
     * @return bool
     */
    protected function isSameAddress(AddressTransfer $shippingAddressTransfer, AddressTransfer $billingAddressTransfer): bool
    {
        return !array_diff($shippingAddressTransfer->toArray(), $billingAddressTransfer->toArray());
    }

    /**
     * @return array
     */
    protected function getAddressChoices()
    {
        if ($this->customerTransfer === null) {
            return [];
        }

        $customerAddressesTransfer = $this->customerTransfer->getAddresses();

        if ($customerAddressesTransfer === null) {
            return [];
        }

        $choices = [];
        foreach ($customerAddressesTransfer->getAddresses() as $address) {
            $choices[$address->getIdCustomerAddress()] = sprintf(
                '%s %s %s, %s %s, %s %s',
                $address->getSalutation(),
                $address->getFirstName(),
                $address->getLastName(),
                $address->getAddress1(),
                $address->getAddress2(),
                $address->getZipCode(),
                $address->getCity()
            );
        }

        return $choices;
    }
}

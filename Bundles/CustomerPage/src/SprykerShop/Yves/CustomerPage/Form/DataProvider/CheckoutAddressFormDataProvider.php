<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Form\DataProvider;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
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
     * @var bool
     */
    protected $isMultipleShipmentEnabled;

    /**
     * @param \SprykerShop\Yves\CustomerPage\Dependency\Client\CustomerPageToCustomerClientInterface $customerClient
     * @param \Spryker\Shared\Kernel\Store $store
     * @param bool $isMultipleShipmentEnabled
     */
    public function __construct(
        CustomerPageToCustomerClientInterface $customerClient,
        Store $store,
        bool $isMultipleShipmentEnabled
    ) {
        parent::__construct($customerClient, $store);

        $this->customerTransfer = $this->getCustomer();
        $this->isMultipleShipmentEnabled = $isMultipleShipmentEnabled;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        /**
         * @todo Add BC
         */

        $quoteTransfer->setShippingAddress($this->getShippingAddress($quoteTransfer));
        $quoteTransfer->setBillingAddress($this->getBillingAddress($quoteTransfer));

        if ($quoteTransfer->getBillingAddress()->toArray() == $quoteTransfer->getShippingAddress()->toArray()) {
            $quoteTransfer->setBillingSameAsShipping(true);
        }

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $itemTransfer->setShipment($this->getItemShipment($itemTransfer));
        }

        $quoteTransfer->setIsMultipleShipmentEnabled($this->isMultipleShipmentEnabled);

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
    protected function getShippingAddress(QuoteTransfer $quoteTransfer)
    {
        $addressTransfer = new AddressTransfer();
        if ($quoteTransfer->getShippingAddress() !== null) {
            $addressTransfer = $quoteTransfer->getShippingAddress();
        }

        if ($this->customerTransfer !== null && $quoteTransfer->getShippingAddress() === null) {
            $addressTransfer->setIdCustomerAddress($this->customerTransfer->getDefaultShippingAddress());
        }

        return $addressTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function getBillingAddress(QuoteTransfer $quoteTransfer)
    {
        $billingAddressTransfer = new AddressTransfer();
        if ($quoteTransfer->getBillingAddress() !== null) {
            $billingAddressTransfer = $quoteTransfer->getBillingAddress();
        }

        if ($this->customerTransfer !== null && $quoteTransfer->getBillingAddress() === null) {
            $billingAddressTransfer->setIdCustomerAddress($this->customerTransfer->getDefaultBillingAddress());
        }

        return $billingAddressTransfer;
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

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ShipmentTransfer
     */
    protected function getItemShipment(ItemTransfer $itemTransfer): ShipmentTransfer
    {
        $shipmentTransfer = $itemTransfer->getShipment();
        if (!$shipmentTransfer) {
            $shipmentTransfer = new ShipmentTransfer();
        }

        $shipmentTransfer->setShippingAddress($this->getShipmentShippingAddress($shipmentTransfer));

        return $shipmentTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ShipmentTransfer $shipmentTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function getShipmentShippingAddress(ShipmentTransfer $shipmentTransfer): AddressTransfer
    {
        $addressTransfer = new AddressTransfer();
        if ($shipmentTransfer->getShippingAddress() !== null) {
            $addressTransfer = $shipmentTransfer->getShippingAddress();
        }

        if ($this->customerTransfer !== null && $shipmentTransfer->getShippingAddress() === null) {
            $addressTransfer->setIdCustomerAddress($this->customerTransfer->getDefaultShippingAddress());
        }

        return $addressTransfer;
    }
}

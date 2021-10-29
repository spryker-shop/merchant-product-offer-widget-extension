<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CheckoutPage\Form;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;
use Spryker\Yves\StepEngine\Form\FormCollectionHandler;
use SprykerShop\Yves\CheckoutPage\CheckoutPageDependencyProvider;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToGlossaryStorageClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToLocaleClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToUtilValidateServiceInterface;
use SprykerShop\Yves\CheckoutPage\Form\DataProvider\SubFormDataProviders;
use SprykerShop\Yves\CheckoutPage\Form\DataProvider\SummaryFormDataProvider;
use SprykerShop\Yves\CheckoutPage\Form\Steps\PaymentForm;
use SprykerShop\Yves\CheckoutPage\Form\Steps\ShipmentCollectionForm;
use SprykerShop\Yves\CheckoutPage\Form\Steps\ShipmentForm;
use SprykerShop\Yves\CheckoutPage\Form\Steps\SummaryForm;

/**
 * @method \SprykerShop\Yves\CheckoutPage\CheckoutPageConfig getConfig()
 */
class FormFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection
     */
    public function getPaymentMethodSubForms()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::PAYMENT_SUB_FORMS);
    }

    /**
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function createCustomerFormCollection()
    {
        return $this->createFormCollection($this->getCustomerFormTypes());
    }

    /**
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function createAddressFormCollection()
    {
        return $this->createFormCollection($this->getAddressFormTypes(), $this->getCheckoutAddressFormDataProviderPlugin());
    }

    /**
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function createShipmentFormCollection()
    {
        return $this->createFormCollection($this->getShipmentFormTypes(), $this->getShipmentFormDataProviderPlugin());
    }

    /**
     * @return array<string>
     */
    public function getShipmentFormTypes()
    {
        return [
            $this->getShipmentCollectionForm(),
        ];
    }

    /**
     * @deprecated Use {@link getShipmentCollectionForm()} instead.
     *
     * @return string
     */
    public function getShipmentForm()
    {
        return ShipmentForm::class;
    }

    /**
     * @return string
     */
    public function getShipmentCollectionForm(): string
    {
        return ShipmentCollectionForm::class;
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function getShipmentFormDataProviderPlugin()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::PLUGIN_SHIPMENT_FORM_DATA_PROVIDER);
    }

    /**
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function getPaymentFormCollection()
    {
        $createPaymentSubForms = $this->getPaymentMethodSubForms();
        $subFormDataProvider = $this->createSubFormDataProvider($createPaymentSubForms);

        return $this->createSubFormCollection(PaymentForm::class, $subFormDataProvider);
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection $subForms
     *
     * @return \SprykerShop\Yves\CheckoutPage\Form\DataProvider\SubFormDataProviders
     */
    public function createSubFormDataProvider(SubFormPluginCollection $subForms)
    {
        return new SubFormDataProviders($subForms);
    }

    /**
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function createSummaryFormCollection()
    {
        return $this->createFormCollection($this->getSummaryFormTypes(), $this->createSummaryFormDataProvider());
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createSummaryFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new SummaryFormDataProvider(
            $this->getConfig(),
            $this->getLocaleClient(),
            $this->getGlossaryStorageClient(),
        );
    }

    /**
     * @return array<\Symfony\Component\Form\FormTypeInterface|string>
     */
    public function getCustomerFormTypes()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::CUSTOMER_STEP_SUB_FORMS);
    }

    /**
     * @return array<\Symfony\Component\Form\FormTypeInterface>
     */
    public function getAddressFormTypes()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::ADDRESS_STEP_SUB_FORMS);
    }

    /**
     * @return array<string>
     */
    public function getSummaryFormTypes()
    {
        return [
            $this->getSummaryForm(),
        ];
    }

    /**
     * @return string
     */
    public function getSummaryForm()
    {
        return SummaryForm::class;
    }

    /**
     * @param array<\Symfony\Component\Form\FormTypeInterface|string> $formTypes
     * @param \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface|null $dataProvider
     *
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function createFormCollection(array $formTypes, ?StepEngineFormDataProviderInterface $dataProvider = null)
    {
        return new FormCollectionHandler($formTypes, $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY), $dataProvider);
    }

    /**
     * @param string $formType
     * @param \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface $dataProvider
     *
     * @return \Spryker\Yves\StepEngine\Form\FormCollectionHandlerInterface
     */
    public function createSubFormCollection($formType, StepEngineFormDataProviderInterface $dataProvider)
    {
        return new FormCollectionHandler([$formType], $this->getFormFactory(), $dataProvider);
    }

    /**
     * @return \Symfony\Component\Form\FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return \Spryker\Yves\Kernel\Application
     */
    public function getApplication()
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::PLUGIN_APPLICATION);
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface
     */
    public function getCustomerClient(): CheckoutPageToCustomerClientInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToLocaleClientInterface
     */
    public function getLocaleClient(): CheckoutPageToLocaleClientInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::CLIENT_LOCALE);
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToGlossaryStorageClientInterface
     */
    public function getGlossaryStorageClient(): CheckoutPageToGlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToUtilValidateServiceInterface
     */
    public function getUtilValidateService(): CheckoutPageToUtilValidateServiceInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::SERVICE_UTIL_VALIDATE);
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function getCheckoutAddressFormDataProviderPlugin(): StepEngineFormDataProviderInterface
    {
        return $this->getProvidedDependency(CheckoutPageDependencyProvider::PLUGIN_CHECKOUT_ADDRESS_FORM_DATA_PROVIDER);
    }
}

<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Controller;

use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @method \SprykerShop\Yves\CustomerPage\CustomerPageFactory getFactory()
 * @method \Spryker\Client\Customer\CustomerClientInterface getClient()
 */
class AccessTokenController extends AbstractCustomerController
{
    /**
     * @deprecated Use {@link \SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin::ROUTE_NAME_CUSTOMER_OVERVIEW} instead.
     *
     * @var string
     */
    protected const ROUTE_CUSTOMER_OVERVIEW = 'customer/overview';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CUSTOMER_ALREADY_LOGGED_IN = 'customer_page.error.customer_already_logged_in';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_INVALID_ACCESS_TOKEN = 'customer_page.error.invalid_access_token';

    /**
     * @param string $token
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(string $token): RedirectResponse
    {
        $response = $this->executeIndexAction($token);

        return $response;
    }

    /**
     * @param string $token
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function executeIndexAction(string $token): RedirectResponse
    {
        if ($this->isLoggedInCustomer()) {
            $this->addErrorMessage(static::GLOSSARY_KEY_CUSTOMER_ALREADY_LOGGED_IN);

            return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_CUSTOMER_OVERVIEW);
        }

        $customerResponseTransfer = $this
            ->getFactory()
            ->getCustomerClient()
            ->getCustomerByAccessToken($token);

        if (!$customerResponseTransfer->getIsSuccess()) {
            $this->addErrorMessage(static::GLOSSARY_KEY_INVALID_ACCESS_TOKEN);

            throw new AccessDeniedHttpException();
        }

        $customerTransfer = $customerResponseTransfer->getCustomerTransfer();
        $token = $this->getFactory()->createUsernamePasswordToken($customerTransfer);

        $this->getFactory()
            ->createCustomerAuthenticator()
            ->authenticateCustomer($customerTransfer, $token);

        return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_CUSTOMER_OVERVIEW);
    }
}

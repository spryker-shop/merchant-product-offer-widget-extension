<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\OrderListTransfer;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;

/**
 * @method \SprykerShop\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class CustomerController extends AbstractCustomerController
{
    /**
     * @var int
     */
    public const ORDER_LIST_LIMIT = 5;

    /**
     * @var string
     */
    public const ORDER_LIST_SORT_FIELD = 'created_at';

    /**
     * @var string
     */
    public const ORDER_LIST_SORT_DIRECTION = 'DESC';

    /**
     * @var string
     */
    public const KEY_BILLING = 'billing';

    /**
     * @var string
     */
    public const KEY_SHIPPING = 'shipping';

    /**
     * @return \Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        $response = $this->executeIndexAction();

        if (!is_array($response)) {
            return $response;
        }

        return $this->view(
            $response,
            $this->getFactory()->getCustomerOverviewWidgetPlugins(),
            '@CustomerPage/views/overview/overview.twig',
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    protected function createOrderListTransfer(CustomerTransfer $customerTransfer)
    {
        $filterTransfer = $this->createFilterTransfer();

        $orderListTransfer = new OrderListTransfer();
        $orderListTransfer->setIdCustomer($customerTransfer->getIdCustomer());
        $orderListTransfer->setFilter($filterTransfer);

        return $orderListTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\FilterTransfer
     */
    protected function createFilterTransfer()
    {
        $filterTransfer = new FilterTransfer();

        $filterTransfer->setLimit(static::ORDER_LIST_LIMIT);
        $filterTransfer->setOffset(0);
        $filterTransfer->setOrderBy(static::ORDER_LIST_SORT_FIELD);
        $filterTransfer->setOrderDirection(static::ORDER_LIST_SORT_DIRECTION);

        return $filterTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    protected function getDefaultAddresses(CustomerTransfer $customerTransfer)
    {
        $addressesTransfer = $customerTransfer->getAddresses();
        if ($addressesTransfer === null) {
            return [];
        }

        $addresses = [];
        foreach ($addressesTransfer->getAddresses() as $address) {
            if ($customerTransfer->getDefaultBillingAddress() === $address->getIdCustomerAddress()) {
                $addresses[static::KEY_BILLING] = $address;
            }

            if ($customerTransfer->getDefaultShippingAddress() === $address->getIdCustomerAddress()) {
                $addresses[static::KEY_SHIPPING] = $address;
            }
        }

        return $addresses;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    protected function executeIndexAction()
    {
        $loggedInCustomerTransfer = $this->getLoggedInCustomerTransfer();

        if (!$loggedInCustomerTransfer->getIdCustomer()) {
            return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_LOGOUT);
        }

        $orderListTransfer = $this->createOrderListTransfer($loggedInCustomerTransfer);
        $orderList = $this->getFactory()->getSalesClient()->getPaginatedCustomerOrdersOverview($orderListTransfer);
        $aggregatedDisplayNames = $this->getFactory()->createItemStateMapper()->aggregateItemStatesDisplayNamesByOrderReference($orderList->getOrders());

        return [
            'customer' => $loggedInCustomerTransfer,
            'orderList' => $orderList->getOrders(),
            'ordersAggregatedItemStateDisplayNames' => $aggregatedDisplayNames,
            'addresses' => $this->getDefaultAddresses($loggedInCustomerTransfer),
        ];
    }
}

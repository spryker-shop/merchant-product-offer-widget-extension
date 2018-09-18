<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShoppingListPage\Business;

use ArrayObject;
use Generated\Shared\Transfer\CompanyBusinessUnitCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use SprykerShop\Yves\ShoppingListPage\Dependency\Client\ShoppingListPageToCompanyBusinessUnitClientInterface;
use SprykerShop\Yves\ShoppingListPage\Dependency\Client\ShoppingListPageToCompanyUserClientInterface;

class SharedShoppingListReader implements SharedShoppingListReaderInterface
{
    /**
     * @var \SprykerShop\Yves\ShoppingListPage\Dependency\Client\ShoppingListPageToCompanyUserClientInterface
     */
    protected $companyUserClient;

    /**
     * @var \SprykerShop\Yves\ShoppingListPage\Dependency\Client\ShoppingListPageToCompanyBusinessUnitClientInterface
     */
    protected $companyBusinessUnitClient;

    /**
     * @param \SprykerShop\Yves\ShoppingListPage\Dependency\Client\ShoppingListPageToCompanyUserClientInterface $companyUserClient
     * @param \SprykerShop\Yves\ShoppingListPage\Dependency\Client\ShoppingListPageToCompanyBusinessUnitClientInterface $companyBusinessUnitClient
     */
    public function __construct(
        ShoppingListPageToCompanyUserClientInterface $companyUserClient,
        ShoppingListPageToCompanyBusinessUnitClientInterface $companyBusinessUnitClient
    ) {
        $this->companyUserClient = $companyUserClient;
        $this->companyBusinessUnitClient = $companyBusinessUnitClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    public function getSharedShoppingListEntities(ShoppingListTransfer $shoppingListTransfer, CustomerTransfer $customerTransfer): array
    {
        return [
            'sharedCompanyUsers' => $this->getSharedCompanyUsers($shoppingListTransfer, $customerTransfer),
            'sharedCompanyBusinessUnits' => $this->getSharedCompanyBusinessUnits($shoppingListTransfer, $customerTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\CompanyUserTransfer[]
     */
    protected function getSharedCompanyUsers(ShoppingListTransfer $shoppingListTransfer, CustomerTransfer $customerTransfer): ArrayObject
    {
        $sharedCompanyUserIds = [];

        foreach ($shoppingListTransfer->getSharedCompanyUsers() as $shoppingListCompanyUserTransfer) {
            $sharedCompanyUserIds[] = $shoppingListCompanyUserTransfer->getIdCompanyUser();
        }

        if (!$sharedCompanyUserIds) {
            return new ArrayObject();
        }

        $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
            ->setIdCompany($customerTransfer->getCompanyUserTransfer()->getFkCompany())
            ->setCompanyUserIds($sharedCompanyUserIds);

        $companyUserTransfers = $this->companyUserClient
            ->getCompanyUserCollection($companyUserCriteriaFilterTransfer)
            ->getCompanyUsers();

        return $companyUserTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer[]
     */
    protected function getSharedCompanyBusinessUnits(ShoppingListTransfer $shoppingListTransfer, CustomerTransfer $customerTransfer): ArrayObject
    {
        $sharedCompanyBusinessUnitIds = [];

        foreach ($shoppingListTransfer->getSharedCompanyBusinessUnits() as $shoppingListCompanyBusinessUnitTransfer) {
            $sharedCompanyBusinessUnitIds[] = $shoppingListCompanyBusinessUnitTransfer->getIdCompanyBusinessUnit();
        }

        if (!$sharedCompanyBusinessUnitIds) {
            return new ArrayObject();
        }

        $companyBusinessUnitCriteriaFilterTransfer = (new CompanyBusinessUnitCriteriaFilterTransfer())
            ->setIdCompany($customerTransfer->getCompanyUserTransfer()->getFkCompany())
            ->setCompanyBusinessUnitIds($sharedCompanyBusinessUnitIds);

        $companyBusinessUnitTransfers = $this->companyBusinessUnitClient
            ->getCompanyBusinessUnitCollection($companyBusinessUnitCriteriaFilterTransfer)
            ->getCompanyBusinessUnits();

        return $companyBusinessUnitTransfers;
    }
}

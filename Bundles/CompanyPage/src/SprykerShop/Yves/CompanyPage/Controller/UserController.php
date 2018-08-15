<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyPage\Controller;

use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\CompanyUser\Plugin\AddCompanyUserPermissionPlugin;
use Spryker\Yves\Kernel\PermissionAwareTrait;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\CompanyPage\Plugin\Provider\CompanyPageControllerProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \SprykerShop\Yves\CompanyPage\CompanyPageFactory getFactory()
 */
class UserController extends AbstractCompanyController
{
    use PermissionAwareTrait;

    public const COMPANY_USER_LIST_SORT_FIELD = 'id_company_user';

    protected const SUCCESS_MESSAGE_COMPANY_USER_DELETE = 'company.account.company_user.delete.successful';
    protected const ERROR_MESSAGE_COMPANY_USER_DELETE = 'company.account.company_user.delete.error';
    protected const ERROR_MESSAGE_COMPANY_USER_ASSIGN_EMPTY_ROLES = 'company.account.company_user.assign_roles.empty_roles.error';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request)
    {
        $viewData = $this->executeIndexAction($request);
        $companyUserOverviewWidgetPlugins = $this->getFactory()
            ->getCompanyUserOverviewWidgetPlugins();

        return $this->view($viewData, $companyUserOverviewWidgetPlugins, '@CompanyPage/views/user/user.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeIndexAction(Request $request): array
    {
        $criteriaFilterTransfer = $this->createCompanyUserCriteriaFilterTransfer($request);

        $companyUserCollectionTransfer = $this->getFactory()
            ->getCompanyUserClient()
            ->getCompanyUserCollection($criteriaFilterTransfer);

        return [
            'pagination' => $companyUserCollectionTransfer->getPagination(),
            'companyUserCollection' => $companyUserCollectionTransfer->getCompanyUsers(),
            'currentCompanyUser' => $this->findCurrentCompanyUserTransfer(),
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $response = $this->executeCreateAction($request);

        if (!is_array($response)) {
            return $response;
        }

        return $this->view($response, [], '@CompanyPage/views/user-create/user-create.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function executeCreateAction(Request $request)
    {
        if (!$this->can(AddCompanyUserPermissionPlugin::KEY)) {
            throw new NotFoundHttpException();
        }

        $dataProvider = $this->getFactory()
            ->createCompanyPageFormFactory()
            ->createCompanyUserFormDataProvider();

        $companyUserForm = $this->getFactory()
            ->createCompanyPageFormFactory()
            ->getCompanyUserForm(
                $dataProvider->getOptions(
                    $this->getCompanyUser()->getFkCompany()
                )
            )
            ->handleRequest($request);

        if ($companyUserForm->isSubmitted() === false) {
            $companyUserForm->setData($dataProvider->getData($this->getCompanyUser()->getFkCompany()));
        } elseif ($companyUserForm->isSubmitted() && $companyUserForm->isValid()) {
            $companyUserResponseTransfer = $this->createCompanyUser($companyUserForm->getData());

            if ($companyUserResponseTransfer->getIsSuccessful()) {
                return $this->redirectResponseInternal(CompanyPageControllerProvider::ROUTE_COMPANY_USER);
            }

            $this->processResponseMessages($companyUserResponseTransfer);
        }

        return [
            'companyUserForm' => $companyUserForm->createView(),
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request)
    {
        $response = $this->executeUpdateAction($request);

        if (!is_array($response)) {
            return $response;
        }

        return $this->view($response, [], '@CompanyPage/views/user-update/user-update.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function executeUpdateAction(Request $request)
    {
        $dataProvider = $this->getFactory()
            ->createCompanyPageFormFactory()
            ->createCompanyUserFormDataProvider();

        $companyUserForm = $this->getFactory()
            ->createCompanyPageFormFactory()
            ->getCompanyUserForm(
                $dataProvider->getOptions(
                    $this->getCompanyUser()->getFkCompany()
                )
            )
            ->handleRequest($request);

        if ($companyUserForm->isSubmitted() === false) {
            $idCompanyUser = $request->query->getInt('id');
            $companyUserForm->setData(
                $dataProvider->getData(
                    $this->getCompanyUser()->getFkCompany(),
                    $idCompanyUser
                )
            );
        } elseif ($companyUserForm->isSubmitted() && $companyUserForm->isValid()) {
            $companyUserResponseTransfer = $this->updateCompanyUser($companyUserForm->getData());

            if ($companyUserResponseTransfer->getIsSuccessful()) {
                return $this->redirectResponseInternal(CompanyPageControllerProvider::ROUTE_COMPANY_USER);
            }

            $this->processResponseMessages($companyUserResponseTransfer);
        }

        return [
            'companyUserForm' => $companyUserForm->createView(),
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $idCompanyUser = $request->query->getInt('id');
        $companyUserTransfer = (new CompanyUserTransfer())
            ->setIdCompanyUser($idCompanyUser);

        $currentCompanyUserTransfer = $this->findCurrentCompanyUserTransfer();
        if ($currentCompanyUserTransfer && $currentCompanyUserTransfer->getIdCompanyUser() === $idCompanyUser) {
            $this->addErrorMessage(static::ERROR_MESSAGE_COMPANY_USER_DELETE);

            return $this->redirectResponseInternal(CompanyPageControllerProvider::ROUTE_COMPANY_USER);
        }

        $companyUserResponseTransfer = $this->getFactory()
            ->getCompanyUserClient()
            ->deleteCompanyUser($companyUserTransfer);

        if ($companyUserResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::SUCCESS_MESSAGE_COMPANY_USER_DELETE);

            return $this->redirectResponseInternal(CompanyPageControllerProvider::ROUTE_COMPANY_USER);
        }

        $this->addErrorMessage(static::ERROR_MESSAGE_COMPANY_USER_DELETE);

        return $this->redirectResponseInternal(CompanyPageControllerProvider::ROUTE_COMPANY_USER);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function confirmDeleteAction(Request $request): View
    {
        $viewData = $this->executeConfirmDeleteAction($request);

        return $this->view($viewData, [], '@CompanyPage/views/user-delete/user-delete.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeConfirmDeleteAction(Request $request): array
    {
        $idCompanyUser = $request->query->getInt('id');

        $companyUserTransfer = (new CompanyUserTransfer())
            ->setIdCompanyUser($idCompanyUser);

        $companyUserTransfer->requireIdCompanyUser();
        $companyUserTransfer = $this->getFactory()
            ->getCompanyUserClient()
            ->getCompanyUserById($companyUserTransfer);

        $companyUserTransfer->requireCustomer();
        $customerTransfer = $companyUserTransfer->getCustomer();

        return [
            'idCompanyUser' => $idCompanyUser,
            'customer' => $customerTransfer,
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    protected function findCurrentCompanyUserTransfer(): ?CompanyUserTransfer
    {
        $currentCustomerTransfer = $this->getFactory()
            ->getCustomerClient()
            ->getCustomer();

        if (!$currentCustomerTransfer) {
            return null;
        }

        return $currentCustomerTransfer->getCompanyUserTransfer();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer
     */
    protected function createCompanyUserCriteriaFilterTransfer(Request $request): CompanyUserCriteriaFilterTransfer
    {
        $criteriaFilterTransfer = new CompanyUserCriteriaFilterTransfer();
        $criteriaFilterTransfer->setIdCompany($this->getCompanyUser()->getFkCompany());

        $filterTransfer = $this->createFilterTransfer(self::COMPANY_USER_LIST_SORT_FIELD);
        $criteriaFilterTransfer->setFilter($filterTransfer);

        $paginationTransfer = $this->createPaginationTransfer($request);
        $criteriaFilterTransfer->setPagination($paginationTransfer);

        return $criteriaFilterTransfer;
    }

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected function createCompanyUser(array $data): CompanyUserResponseTransfer
    {
        $companyUserTransfer = new CompanyUserTransfer();
        $companyUserTransfer->fromArray($data, true);

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->fromArray($data, true);
        $customerTransfer->setSendPasswordToken(true);

        $companyUserTransfer->setCustomer($customerTransfer);

        return $this->getFactory()->getCompanyUserClient()->createCompanyUser($companyUserTransfer);
    }

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected function updateCompanyUser(array $data): CompanyUserResponseTransfer
    {
        $companyUserTransfer = new CompanyUserTransfer();
        $companyUserTransfer->fromArray($data, true);

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->fromArray($data, true);

        $companyUserTransfer->setCustomer($customerTransfer);

        return $this->getFactory()->getCompanyUserClient()->updateCompanyUser($companyUserTransfer);
    }
}

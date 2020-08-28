<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Controller;

use Generated\Shared\Transfer\CompanyUserInvitationSendRequestTransfer;
use Generated\Shared\Transfer\CompanyUserInvitationTransfer;
use SprykerShop\Yves\CompanyUserInvitationPage\Plugin\Router\CompanyUserInvitationPageRouteProviderPlugin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageFactory getFactory()
 */
class ResendController extends AbstractController
{
    protected const PARAM_ID_COMPANY_USER_INVITATION = 'idCompanyUserInvitation';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request)
    {
        $viewData = $this->executeIndexAction($request);

        return $this->view($viewData, [], '@CompanyUserInvitationPage/views/invitation-resend/invitation-resend.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeIndexAction(Request $request): array
    {
        return [
            'idCompanyUserInvitation' => (int)$request->get(static::PARAM_ID_COMPANY_USER_INVITATION),
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmAction(Request $request): RedirectResponse
    {
        $invitationId = (int)$request->get(static::PARAM_ID_COMPANY_USER_INVITATION);
        $companyUserInvitationSendRequestTransfer = (new CompanyUserInvitationSendRequestTransfer())
            ->setIdCompanyUser($this->companyUserTransfer->getIdCompanyUser())
            ->setCompanyUserInvitation(
                (new CompanyUserInvitationTransfer())->setIdCompanyUserInvitation($invitationId)
            );

        $companyUserInvitationSendResponseTransfer = $this->getFactory()
            ->getCompanyUserInvitationClient()
            ->sendCompanyUserInvitation($companyUserInvitationSendRequestTransfer);

        if ($companyUserInvitationSendResponseTransfer->getIsSuccess()) {
            return $this->redirectToRouteWithSuccessMessage(
                CompanyUserInvitationPageRouteProviderPlugin::ROUTE_NAME_OVERVIEW,
                'company.user.invitation.resent.success.message'
            );
        }

        return $this->redirectToRouteWithErrorMessage(
            CompanyUserInvitationPageRouteProviderPlugin::ROUTE_NAME_OVERVIEW,
            'company.user.invitation.resent.error.message'
        );
    }
}

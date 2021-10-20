<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CompanyUserInvitationPage\Model\Error;

use EmptyIterator;
use Generated\Shared\Transfer\CompanyUserInvitationImportResponseTransfer;
use Iterator;
use League\Csv\Reader;
use League\Csv\Writer;
use SprykerShop\Shared\CompanyUserInvitationPage\CompanyUserInvitationPageConstants;
use SprykerShop\Yves\CompanyUserInvitationPage\CompanyUserInvitationPageConfig;
use SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToSessionClientInterface;

class ImportErrorHandler implements ImportErrorHandlerInterface
{
    /**
     * @var \SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToSessionClientInterface
     */
    protected $sessionClient;

    /**
     * @param \SprykerShop\Yves\CompanyUserInvitationPage\Dependency\Client\CompanyUserInvitationPageToSessionClientInterface $sessionClient
     */
    public function __construct(
        CompanyUserInvitationPageToSessionClientInterface $sessionClient
    ) {
        $this->sessionClient = $sessionClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserInvitationImportResponseTransfer $companyUserInvitationImportResponseTransfer
     *
     * @return mixed
     */
    public function storeCompanyUserInvitationImportErrors(
        CompanyUserInvitationImportResponseTransfer $companyUserInvitationImportResponseTransfer
    ) {
        $importErrorsFile = $this->getImportErrorsFile();
        $writer = Writer::createFromPath($importErrorsFile, 'w+');
        foreach ($companyUserInvitationImportResponseTransfer->getErrors() as $error) {
            $writer->insertOne([$error]);
        }

        return $this->sessionClient->set(
            CompanyUserInvitationPageConfig::INVITATION_IMPORT_ERRORS_FILE,
            $importErrorsFile,
        );
    }

    /**
     * @return \Iterator
     */
    public function retrieveCompanyUserInvitationImportErrors(): Iterator
    {
        $importErrorsFile = $this->sessionClient->get(CompanyUserInvitationPageConfig::INVITATION_IMPORT_ERRORS_FILE, null);
        if ($importErrorsFile) {
            return Reader::createFromPath($importErrorsFile, 'r')->getRecords();
        }

        return new EmptyIterator();
    }

    /**
     * @return string
     */
    protected function getImportErrorsFile(): string
    {
        return tempnam(
            CompanyUserInvitationPageConstants::IMPORT_ERRORS_FILE_PATH,
            CompanyUserInvitationPageConfig::IMPORT_ERRORS_FILE_PREFIX,
        );
    }
}

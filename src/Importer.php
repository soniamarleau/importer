<?php

namespace SonarSoftware\Importer;

use Exception;
use InvalidArgumentException;
use SonarSoftware\Importer\Extenders\AccessesSonar;

class Importer extends AccessesSonar
{
    /**
     * @param $pathToImportFile - The full path to the account custom fields file
     * @return array
     */
    public function importAccountCustomFields($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new AccountCustomFieldImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the accounts CSV file.
     * @return array
     */
    public function importAccounts($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new AccountImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile  - Input the full path to the accounts CSV file.
     * @return array
     */
    public function importContacts($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new ContactImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account services CSV file.
     * @return array
     */
    public function importAccountServices($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.3");

        $importer = new AccountServiceImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account packages CSV file.
     * @return array
     */
    public function importAccountPackages($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new AccountPackageImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account billing parameters CSV file.
     * @return array
     */
    public function importAccountBillingParameters($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.3");

        $importer = new AccountBillingParameterImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account secondary address CSV file.
     * @param bool $validateAddress - Set this to 'true' if you want Sonar to submit the address for verification. This may cause issues with some addresses (e.g. PO Boxes)
     * @return array
     */
    public function importAccountSecondaryAddresses($pathToImportFile, $validateAddress = false)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new AccountSecondaryAddressImporter();
        return $importer->import($pathToImportFile, $validateAddress);
    }

    /**
     * @param $pathToImportFile - Input the full path to the tokenized credit card CSV file.
     * @return array
     */
    public function importTokenizedCreditCards($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new TokenizedCreditCardImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the untokenized credit card CSV file.
     * @return array
     */
    public function importUntokenizedCreditCards($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new UntokenizedCreditCardImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the untokenized bank accounts CSV file.
     * @return array
     */
    public function importUntokenizedBankAccounts($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new UntokenizedBankAccountImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the tokenized bank accounts CSV file.
     * @return array
     */
    public function importTokenizedBankAccounts($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new TokenizedBankAccountImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account files CSV file.
     * @return array
     */
    public function importAccountFiles($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new AccountFileImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account notes CSV file.
     * @return array
     */
    public function importAccountNotes($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new NoteImporter();
        return $importer->import($pathToImportFile,"accounts");
    }

    /**
     * @param $pathToImportFile - Input the full path to the network sites CSV file.
     * @param bool $validateAddress - Set this to 'true' if you want Sonar to submit the address for verification. This may cause issues with some addresses (e.g. PO Boxes)
     * @return array
     */
    public function importNetworkSites($pathToImportFile, $validateAddress = false)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new NetworkSiteImporter();
        return $importer->import($pathToImportFile,$validateAddress);
    }

    /**
     * @param $pathToImportFile - Input the full path to the inventory items CSV file.
     * @param bool $discardInvalidFields
     * @return array
     */
    public function importInventoryItems($pathToImportFile, $discardInvalidFields = false)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.8");

        $importer = new InventoryImporter();
        return $importer->import($pathToImportFile, $discardInvalidFields);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account IPs associated with MACs CSV file.
     * @return array
     */
    public function importAccountIpsWithMacAddresses($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.1");

        $importer = new AccountIpMacAssignmentImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account IPs CSV file.
     * @return array
     */
    public function importAccountIps($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.1");

        $importer = new AccountIpAssignmentImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the network IPs associated with MACs CSV file.
     * @param bool $skipMissing - If this is true, then if a MAC entered in the import doc is not found in Sonar, it will be added to the failures list, but will not throw an Exception.
     * @return array
     */
    public function importNetworkSiteIpsWithMacAddresses($pathToImportFile, $skipMissing = false)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.2");

        $importer = new NetworkIPMacAssignmentImporter();
        return $importer->import($pathToImportFile, $skipMissing);
    }

    /**
     * @param $pathToImportFile - Input the full path to the network IP assignment CSV file.
     * @return array
     */
    public function importNetworkSiteIps($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.2");

        $importer = new NetworkSiteIpAssignmentImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Path to the account next bill date CSV
     * @return array
     */
    public function importUpdateNextBillDate($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.2.0");

        $importer = new AccountNextBillDateImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the accounts CSV file.
     * @param int $debitAdjustmentID - An ID for an unlimited debit adjustment service
     * @param int $creditAdjustmentID - An ID for an unlimited credit adjustment service
     * @return array
     */
    public function updateBalances($pathToImportFile, $debitAdjustmentID, $creditAdjustmentID)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new BalanceImporter($debitAdjustmentID, $creditAdjustmentID);
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the services CSV file.
     * @return array
     */
    public function importServices($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.3.2");

        $importer = new ServiceImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the subnets CSV file.
     * @return array
     */
    public function importSubnets($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.0");

        $importer = new SubnetImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the subnets CSV file.
     * @return array
     */
    public function importIpPools($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.0");

        $importer = new IPPoolImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the tickets CSV file.
     * @return array
     */
    public function importTickets($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("1.0.0");

        $importer = new TicketImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the RADIUS account CSV file
     * @return array
     */
    public function importRadiusAccounts($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.0");

        $importer = new RadiusImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the call log CSV file
     * @return array
     */
    public function importCallLogs($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.4.0");

        $importer = new CallLogImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the scheduled job CSV file
     * @return array
     */
    public function importScheduledJobs($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("1.0.0");

        $importer = new ScheduledJobImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile - Input the full path to the account DIDs file
     * @return array
     */
    public function importAccountDids($pathToImportFile)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.6.11");

        $importer = new AccountDidImporter();
        return $importer->import($pathToImportFile);
    }

    /**
     * @param $pathToImportFile
     * @return array
     */
    public function generateInvoicesWithDebits($pathToImportFile, $debitAdjustmentServiceID)
    {
        set_time_limit(0);
        $this->validateCredentials();
        $this->validateVersion("0.6.11");

        $importer = new InvoiceWithDebitsImporter();
        return $importer->import($pathToImportFile, $debitAdjustmentServiceID);
    }

    /**
     * Validate that the version of the remote Sonar instance is valid.
     * @param $requiredVersion
     * @return bool
     */
    private function validateVersion($requiredVersion)
    {
        $response = $this->client->get($this->uri . "/api/v1/_data/version", [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 30,
            ],
            'auth' => [
                $this->username,
                $this->password,
            ],
        ]);

        $responseData = json_decode($response->getBody());

        if ($this->equalToOrNewerThanVersion($responseData->data->version,$requiredVersion) !== true)
        {
            throw new InvalidArgumentException("Invalid Sonar version, this importer requires version $requiredVersion or higher.");
        }

        return true;
    }

    /**
     * Validate the credentials. This will throw an exception on failure.
     * @return bool
     */
    private function validateCredentials()
    {
        try {
            $this->client->get($this->uri . "/api/v1/_data/version", [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF8',
                    'timeout' => 30,
                ],
                'auth' => [
                    $this->username,
                    $this->password,
                ],
            ]);
        }
        catch (Exception $e)
        {
            throw new InvalidArgumentException("Your credentials appear to be invalid or the Sonar server is inaccessible. Specific error is '{$e->getMessage()}'");
        }

        return true;
    }

    /**
     * @param $currentVersion - Version of the Sonar system
     * @param $versionToCheck - Version that is required
     * @return bool
     */
    private function equalToOrNewerThanVersion($currentVersion, $versionToCheck)
    {
        $currentVersionArray = explode(".",$currentVersion);
        $versionToCheckArray = explode(".",$versionToCheck);

        //1.0.0 is older than 2.0.0
        if ($currentVersionArray[0] < $versionToCheckArray[0])
        {
            return false;
        }

        if ($currentVersionArray[0] > $versionToCheckArray[0])
        {
            return true;
        }

        //Same major version
        if ($currentVersionArray[0] == $versionToCheckArray[0])
        {
            if ($currentVersionArray[1] < $versionToCheckArray[1])
            {
                return false;
            }

            if ($currentVersionArray[1] > $versionToCheckArray[1])
            {
                return true;
            }

            if ($currentVersionArray[1] == $versionToCheckArray[1])
            {
                if ($currentVersionArray[2] < $versionToCheckArray[2])
                {
                    return false;
                }

                if ($currentVersionArray[2] >= $versionToCheckArray[2])
                {
                    return true;
                }
            }
        }

        return false;
    }

}
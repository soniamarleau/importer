<?php

namespace SonarSoftware\Importer;

use Exception;
use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;

class AccountServiceImporter
{
    private $uri;
    private $username;
    private $password;
    private $client;

    /**
     * Services pulled from the API
     * @var
     */
    private $services;

    /**
     * Importer constructor.
     */
    public function __construct()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        $dotenv->load();
        $dotenv->required(
            [
                'URI',
                'USERNAME',
                'PASSWORD',
            ]
        );

        $this->uri = getenv("URI");
        $this->username = getenv("USERNAME");
        $this->password = getenv("PASSWORD");

        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @param $pathToImportFile
     * @return array
     */
    public function import($pathToImportFile)
    {
        if (($handle = fopen($pathToImportFile,"r")) !== FALSE)
        {
            $this->loadServiceData();
            $this->validateImportFile($pathToImportFile);

            if (!file_exists(__DIR__ . "/../log_output"))
            {
                mkdir(__DIR__ . "/../log_output");
            }

            $failureLogName = tempnam(__DIR__ . "/../log_output","account_service_import_failures");
            $failureLog = fopen($failureLogName,"w");

            $successLogName = tempnam(__DIR__ . "/../log_output","account_service_import_successes");
            $successLog = fopen($successLogName,"w");

            $returnData = [
                'successes' => 0,
                'failures' => 0,
                'failure_log_name' => $failureLogName,
                'success_log_name' => $successLogName,
            ];

            $row = 0;
            while (($data = fgetcsv($handle, 8096, ",")) !== FALSE) {
                $row++;
                try {
                    $this->addServiceToAccount($data);
                }
                catch (ClientException $e)
                {
                    $response = $e->getResponse();
                    $body = json_decode($response->getBody());
                    $returnMessage = implode(", ",(array)$body->error->message);
                    fwrite($failureLog,"Row $row failed: $returnMessage\n");
                    $returnData['failures'] += 1;
                    continue;
                }
                catch (Exception $e)
                {
                    fwrite($failureLog,"Row $row failed: {$e->getMessage()}\n");
                    $returnData['failures'] += 1;
                    continue;
                }

                $returnData['successes'] += 1;
                fwrite($successLog,"Row $row succeeded for account ID " . trim($data[0]) . "\n");
            }
        }
        else
        {
            throw new InvalidArgumentException("File could not be opened.");
        }

        fclose($failureLog);
        fclose($successLog);

        return $returnData;
    }

    /**
     * Load service data into a private var.
     */
    private function loadServiceData()
    {
        $serviceArray = [];

        $response = $this->client->get($this->uri . "/api/v1/system/services", [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 30,
            ],
            'auth' => [
                $this->username,
                $this->password,
            ]
        ]);

        $objResponse = json_decode($response->getBody());
        foreach ($objResponse->data as $datum)
        {
            if ($datum->type == "recurring" || $datum->type == "expiring")
            {
                $serviceArray[$datum->id] = [
                    'type' => $datum->type,
                    'application' => $datum->application,
                ];
            }
        }

        while ($objResponse->paginator->current_page != $objResponse->paginator->total_pages)
        {
            $response = $this->client->get($this->uri . "/api/v1/system/services", [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF8',
                    'timeout' => 30,
                ],
                'auth' => [
                    $this->username,
                    $this->password,
                ]
            ]);

            $objResponse = json_decode($response->getBody());
            foreach ($objResponse->data as $datum)
            {
                if ($datum->type == "recurring" || $datum->type == "expiring")
                {
                    $serviceArray[$datum->id] = [
                        'type' => $datum->type,
                        'application' => $datum->application,
                    ];
                }
            }
        }

        $this->services = $serviceArray;
    }

    /**
     * @param $pathToImportFile
     */
    private function validateImportFile($pathToImportFile)
    {
        $requiredColumns = [ 0,1 ];

        if (($fileHandle = fopen($pathToImportFile,"r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($fileHandle, 8096, ",")) !== FALSE) {
                $row++;
                foreach ($requiredColumns as $colNumber) {
                    if (trim($data[$colNumber]) == '') {
                        throw new InvalidArgumentException("In the account service import, column number " . ($colNumber + 1) . " is required, and it is empty on row $row.");
                    }
                }

                if (!array_key_exists($data[1],$this->services))
                {
                    throw new InvalidArgumentException("Service ID {$data[1]} is not a recurring or expiring service.");
                }
            }
        }
        else
        {
            throw new InvalidArgumentException("Could not open import file.");
        }

        return;
    }

    /**
     * Add service to account
     * @param $data
     * @return mixed
     */
    private function addServiceToAccount($data)
    {
        $payload = [
            'service_id' => (int)trim($data[1]),
            'prorate' => false
        ];

        $accountID = (int)trim($data[0]);

        return $this->client->post($this->uri . "/api/v1/accounts/$accountID/services", [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 30,
            ],
            'auth' => [
                $this->username,
                $this->password,
            ],
            'json' => $payload,
        ]);
    }
}
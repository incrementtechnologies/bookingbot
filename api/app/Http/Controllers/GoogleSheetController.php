<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleSheetController
{
    private $spreadSheetID;
    private $range;
    private $values;
    private $client;
    private $service;
    private $body = [];

    public function __construct($spreadSheetID, $range){

        $this->client = new \Google_Client();
        $this->client->setApplicationName('Increment API');
        $this->client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setAccessType('offline');
        $this->client->setAuthConfig(storage_path('credentials/credentials.json'));
        $this->service = new \Google_Service_Sheets($this->client);

        $this->spreadSheetID = $spreadSheetID;
        $this->range = $range;
    }

    public function write($values){

        array_push($this->body, $values);
        $data = new \Google_Service_Sheets_ValueRange([
            'values' => $this->body
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        $result = $this->service->spreadsheets_values->append($this->spreadSheetID, $this->range, $data, $params);

        return $result;

    }

    public function retrieve(){
        $result = $this->service->spreadsheets_values->get($this->spreadSheetID, $this->range);
        return $result;
    }
}

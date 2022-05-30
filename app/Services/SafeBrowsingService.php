<?php

namespace App\Services;

class SafeBrowsingService
{

    private $key = "";
    private $apiUrl = "";
    private $requestedUrl = "";

    public function __construct($requestedUrl = null)
    {
        $this->init($requestedUrl);
    }

    private function init($requestedUrl)
    {
        $this->apiUrl = rtrim(env('GOOGLE_SAFE_BROWSING_API_URL'), '/');
        $this->key = env('GOOGLE_SAFE_BROWSING_API_KEY');

        if (!is_null($requestedUrl)) {
            $this->requestedUrl = $requestedUrl;
        }
    }

    public function request()
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL => $this->getPostUrl(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $this->preparePayload(),
                CURLOPT_HTTPHEADER => $this->getHeaders(),
            ]
        );

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    private function getPostUrl()
    {
        return $this->apiUrl . '/?' . http_build_query(['key' => $this->key]);
    }

    private function getHeaders()
    {
        return [
            'Accept: application/json',
            'Content-Type: application/json'
        ];
    }

    private function preparePayload()
    {
        $payload = [
            'client' => [
                'clientId' => 'url_shortener_task',
                'clientVersion' => '1.1',
            ],
            'threatInfo' => [
                'threatTypes' => [
                    'MALWARE',
                    'SOCIAL_ENGINEERING',
                ],
                'platformTypes' => [
                    'WINDOWS',
                ],
                'threatEntryTypes' => [
                    'URL',
                ],
                'threatEntries' => [
                    [
                        'url' => $this->requestedUrl
                    ]
                ]
            ]
        ];

        return json_encode($payload);
    }
}

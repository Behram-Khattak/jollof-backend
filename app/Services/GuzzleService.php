<?php

namespace App\Services;

use GuzzleHttp\Client;

class GuzzleService
{
    public $endPointUrl;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($url, $options)
    {
        $this->endPointUrl = $url;

        try {
            $response = $this->client->request('GET', $this->endPointUrl, $options);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }

        return $this->handleResponse($response->getBody()->getContents());
    }

    public function post($url, $options)
    {
        $this->endPointUrl = $url;
        try {
            $response = $this->client->request('POST', $this->endPointUrl, $options);
        } catch (\Exception $e) {
            //echo "here";
            dd($e); //$e->getHandlerContext()
            //return $this->handleException($e->getHandlerContext());
        }

        return $this->handleResponse($response->getBody()->getContents());
    }

    public function handleException($e)
    {
        return [
            // 'code' => $e->getResponse()->getStatusCode(),
            // 'message' => $e->getResponse()->getReasonPhrase()
            // "errno" => $e['errno'],
            // "error" => $e['error'],
            // "url" => $e['url']
        ];
    }

    public function handleResponse($response)
    {
        return json_decode($response);
    }
}

<?php

namespace Cherrypulp\LaravelActito;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class Actito
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @var mixed
     */
    public $version;

    /**
     * @var mixed
     */
    private $key;

    /**
     * Actito constructor.
     * @param array $config
     * @param ClientInterface|null $client
     */
    public function __construct(array $config = [], ClientInterface $client = null)
    {
        $this->key = $config['key'];
        $this->version = $config['version'];

        if (!$client) {
            $this->client = new Client($config);
        }
    }

    /**
     * @param $uri
     * @param array $options
     * @param null $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function delete($uri, $options = [], $version = null)
    {
        return $this->request('DELETE', $uri, $options, $version);
    }

    /**
     * Request api calls with an access_token
     *
     * @param string $method
     * @param $uri
     * @param array $options
     * @param null $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function request($method, $uri, $options = [], $version = null, $debug = false)
    {
        $token = $this->getToken();

        $uri = ($version ?? $this->version) . '/' . $uri;

        $options['headers']['Authorization'] = 'Bearer ' . $token->accessToken;
        $options['headers']['Accept'] = 'application/json';

        try {
            $reponse = $this->client->request($method, $uri, $options);
            return json_decode($reponse->getBody());
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        $result = $this->client->get('auth/token', [
            'headers' => [
                'Authorization' => $this->key,
                'Accept' => 'application/json'
            ]
        ]);

        return \GuzzleHttp\json_decode($result->getBody());
    }

    /**
     * @param $uri
     * @param array $options
     * @param null $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function get($uri, $options = [], $version = null)
    {
        return $this->request('GET', $uri, $options, $version);
    }

    /**
     * @param $uri
     * @param array $options
     * @param null $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function patch($uri, $options = [], $version = null)
    {
        return $this->request('PATCH', $uri, $options, $version);
    }

    /**
     * @param $uri
     * @param array $options
     * @param null $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function put($uri, $options = [], $version = null)
    {
        return $this->request('PUT', $uri, $options, $version);
    }

    /**
     * Update or create helper for Actito
     *
     * @param string $entity
     * @param array $params
     * @see
     */
    public function updateOrCreate(string $entity, string $table, array $data, $dataCollectionInformation = null, $debug = false)
    {
        $jsonBody = [];

        if ($dataCollectionInformation === null) {
            $jsonBody['dataCollectionInformation'] = [
                'source' => config('app.name'),
                'way' => 'api_push',
                'date' => date('Y-m-d H:i:s')
            ];
        }

        if (isset($data['attributes'])) {
            $jsonBody['attributes'] = [];
            foreach ($data['attributes'] as $key => $value) {
                $jsonBody['attributes'][] = [
                    'name' => $key,
                    'value' => $value
                ];
            }
        }

        if (isset($data['subscriptions'])) {
            $jsonBody['subscriptions'] = [];
            foreach ($data['subscriptions'] as $key => $value) {
                $jsonBody['subscriptions'][] = [
                    'name' => $key,
                    'subscribe' => $value
                ];
            }
        }

        if (isset($data['segmentations'])) {
            $jsonBody['segmentations'] = $data['segmentations'];
        }

        try {

            $response = $this->post("entity/{$entity}/table/{$table}/profile", [
                RequestOptions::JSON => $jsonBody
            ], 'v4');

            return $response;

        } catch (\Throwable $e) {
            if ($debug) {
                ddd(json_decode($e->getResponse()->getBody()));
            }
            throw $e;
        }
    }

    /**
     * @param $uri
     * @param array $options
     * @param null $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function post($uri, $options = [], $version = null)
    {
        return $this->request('POST', $uri, $options, $version);
    }

    public function updateOrCreateCustomTable(string $entity, string $table, array $data, $debug = false)
    {
        $jsonBody = [];

        if (isset($data['properties'])) {
            $jsonBody['properties'] = [];
            foreach ($data['properties'] as $key => $value) {
                $jsonBody['properties'][] = [
                    'name' => $key,
                    'value' => $value
                ];
            }
        }

        try {

            $response = $this->post("entity/{$entity}/customTable/{$table}/record", [
                RequestOptions::JSON => $jsonBody
            ], 'v4');

            return $response;

        } catch (\Throwable $e) {

            if ($debug) {
                d($jsonBody);
                echo $e->getResponse()->getBody();
                echo \GuzzleHttp\json_encode($jsonBody);
            } else {
                throw $e;
            }

        }
    }
}

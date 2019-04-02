<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:06
 */

namespace SportMonks\API;


use GuzzleHttp\Psr7\Request;

class HTTP
{
    protected $requestHeaders;

    /**
     * @param HTTPClient $client
     * @param string $endpoint
     * @param array $options
     *
     * @return \stdClass | null
     * @throws Exceptions\AuthException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(HTTPClient $client, $endpoint, $options)
    {
        $options = array_merge(
            [
                'method'      => 'GET',
                'contentType' => 'application/json',
                'postFields'  => null,
                'queryParams' => null
            ],
            $options
        );

        $headers = array_merge([
            'Accept'       => 'application/json',
            'Content-Type' => $options['contentType'],
            'User-Agent'   => $client->getUserAgent()
        ], $client->getHeaders());

        $request = new Request(
            $options['method'],
            $client->getApiBaseUrl() . $client->getApiBasePath() . $endpoint,
            $headers
        );

        $requestOptions = [];


        if ($client->getAuth()){
            list ($request, $requestOptions) = $client->getAuth()->prepareRequest($request, $requestOptions);
        }

        // Set query parameters like pagination.
        if(array_key_exists('queryParams', $options) && array_key_exists('query', $options['queryParams'])){
            $requestOptions['query'] = array_merge($requestOptions['query'], $options['queryParams']['query']);
        }

        $response = $client->guzzle->send($request, $requestOptions);

        $this->requestHeaders = $response->getHeaders();

        return json_decode($response->getBody());
    }

    /**
     * @return integer | null
     */
    public function getRateLimit()
    {
        return is_array($this->requestHeaders) && array_key_exists('X-RateLimit-Limit', $this->requestHeaders) ? (int)current($this->requestHeaders['X-RateLimit-Limit']) : null;
    }

    /**
     * @return integer | null
     */
    public function getRateLimitRemaining()
    {
        return is_array($this->requestHeaders) && array_key_exists('X-RateLimit-Remaining', $this->requestHeaders) ? (int)current($this->requestHeaders['X-RateLimit-Remaining']) : null;
    }
}
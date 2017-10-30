<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 30.10.17
 * Time: 16:50
 */

namespace SportMonks\API;


use GuzzleHttp\HandlerStack;

class HTTPClient
{
    const API_VERSION = '2.0';

    /**
     * @var array $headers
     */
    private $headers = [];

    /**
     * @var string $scheme
     */
    protected $scheme;
    /**
     * @var string $hostname
     */
    protected $hostname;
    /**
     * @var string $subDomain
     */
    protected $subDomain;
    /**
     * @var int $port
     */
    protected $port;

    /**
     * @var \GuzzleHttp\Client $guzzle
     */
    public $guzzle;

    /**
     * HristonevSportMonksClientBundle constructor.
     * @param string $scheme
     * @param string $hostname
     * @param string $subDomain
     * @param int $port
     */
    public function __construct(
        $scheme = 'https',
        $hostname = 'sportmonks.com',
        $subDomain = 'soccer',
        $port = 443
    )
    {
        $this->scheme = $scheme;
        $this->hostname = $hostname;
        $this->subDomain = $subDomain;
        $this->port = $port;

        $handler = HandlerStack::create();
        $this->guzzle = new \GuzzleHttp\Client(compact('handler'));
    }
}
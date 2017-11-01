<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 30.10.17
 * Time: 16:50
 */

namespace SportMonks\API;


use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use SportMonks\API\Middleware\RetryHandler;
use SportMonks\API\Resources\Bookmakers;
use SportMonks\API\Resources\Continents;
use SportMonks\API\Resources\Countries;
use SportMonks\API\Resources\Fixtures;
use SportMonks\API\Resources\Head2Head;
use SportMonks\API\Resources\Highlights;
use SportMonks\API\Resources\Leagues;
use SportMonks\API\Resources\LiveScores;
use SportMonks\API\Resources\Players;
use SportMonks\API\Resources\Rounds;
use SportMonks\API\Resources\Seasons;
use SportMonks\API\Resources\Teams;
use SportMonks\API\Resources\Venues;
use SportMonks\API\Traits\Utility\InitTrait;
use SportMonks\API\Utilities\Auth;

/**
 * Class HTTPClient
 * @package SportMonks\API
 *
 * @method Continents continents()
 * @method Countries countries()
 * @method Leagues leagues()
 * @method Seasons seasons()
 * @method Fixtures fixtures()
 * @method LiveScores liveScores()
 * @method Highlights highlights()
 * @method Teams teams()
 * @method Head2Head head2Head()
 * @method Venues venues()
 * @method Bookmakers bookmakers()
 * @method Players players()
 * @method Rounds rounds()
 */
class HTTPClient extends HTTP
{
    use InitTrait;

    const API_VERSION = '2.0';

    const BASE_PATH = 'api';

    /**
     * @var array $headers
     */
    private $headers = [];

    /**
     * @var string
     */
    protected $apiBaseUrl;

    /**
     * @var string
     */
    protected $apiBasePath;

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
     * @var Auth $auth
     */
    protected $auth;

    /**
     * @var \GuzzleHttp\Client $guzzle
     */
    public $guzzle;

    /**
     * @param string $scheme
     * @param string $hostname
     * @param string $subDomain
     * @param int $port
     */
    public function __construct($scheme = 'https', $hostname = 'sportmonks.com', $subDomain = 'soccer', $port = 443)
    {
        $this->scheme = $scheme;
        $this->hostname = $hostname;
        $this->subDomain = $subDomain;
        $this->port = $port;

        $handler = HandlerStack::create();
        $handler->push(new RetryHandler(['retry_if' => function ($retries, $request, $response, $e) {
            return $e instanceof RequestException && strpos($e->getMessage(), 'ssl') !== false;
        }]), 'retry_handler');
        $this->guzzle = new \GuzzleHttp\Client(compact('handler'));

        if (empty($subDomain)) {
            $this->apiBaseUrl = "$scheme://$hostname:$port/";
        } else {
            $this->apiBaseUrl = "$scheme://$subDomain.$hostname:$port/";
        }
    }

    /**
     * @return array
     */
    public static function getValidEndpoints()
    {
        return [
            'continents' => Continents::class,
            'countries' => Countries::class,
            'leagues' => Leagues::class,
            'seasons' => Seasons::class,
            'fixtures' => Fixtures::class,
            'liveScores' => LiveScores::class,
            'highlights' =>Highlights::class,
            'teams' => Teams::class,
            'head2Head' => Head2Head::class,
            'venues' => Venues::class,
            'bookmakers' => Bookmakers::class,
            'players' => Players::class,
            'rounds' => Rounds::class
        ];
    }

    /**
     * @return string
     */
    public function getApiBaseUrl()
    {
        return $this->apiBaseUrl;
    }

    /**
     * @return string | null
     */
    public function getApiBasePath()
    {
        if(is_null($this->apiBasePath)){
            $this->apiBasePath = self::BASE_PATH. '/';
        }

        return $this->apiBasePath. 'v'. self::API_VERSION. '/';
    }

    /**
     * @param string $apiBasePath
     */
    public function setApiBasePath($apiBasePath)
    {
        $this->apiBasePath = $apiBasePath;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return 'SportMonksAPI/Hristonev v'. self::API_VERSION;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Configure authentication method.
     *
     * @param $method
     * @param array $options
     *
     * @internal param Auth $auth
     */
    public function setAuth($method, array $options)
    {
        $this->auth = new Auth($method, $options);
    }

    /**
     * @param string $endpoint
     * @param array $queryParams
     *
     * @return \stdClass | null
     */
    public function get($endpoint, $queryParams = [])
    {
//        $sideloads = $this->getSideload($queryParams);
//
//        if (is_array($sideloads)) {
//            $queryParams['include'] = implode(',', $sideloads);
//            unset($queryParams['sideload']);
//        }

        $response = Http::send(
            $this,
            $endpoint,
            ['queryParams' => $queryParams]
        );

        return $response;
    }
}
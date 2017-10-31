<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 21:22
 */

namespace SportMonks\API\tests;

use SportMonks\API\HTTPClient;
use SportMonks\API\Utilities\Auth;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HTTPClient
     */
    private $client;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new HTTPClient();
        $this->client->setAuth(Auth::BASIC, [
            'token' => getenv('TOKEN')
        ]);
    }

    public function testContinents()
    {
        $collection = $this->client->continents()->findAll();
        echo "Continents ". count($collection). "\n";
        $data = current($collection);
        if(is_object($data)){
            $this->client->continents()->find($data->id);
        }
        $this->printLimit();
    }

    public function testLeagues()
    {
        $collection = $this->client->leagues()->findAll();
        echo "Leagues ". count($collection). "\n";
        $data = current($collection);
        if(is_object($data)) {
            $this->client->leagues()->find($data->id);
        }
        $this->printLimit();
    }

    public function testSeasons()
    {
        $collection = $this->client->seasons()->findAll();
        echo "Seasons ". count($collection). "\n";
        $data = current($collection);
        if(is_object($data)) {
            $this->client->seasons()->find($data->id);
            $this->client->seasons()->find($data->id, true);
        }
        $this->printLimit();
    }

    public function testCountries()
    {
        $countryCollection = [];
        do{
            $countryCollection = array_merge($countryCollection, $this->client->countries()->findAll());
        }while($this->client->countries()->nextPage());
        echo "Paginated countries ". count($countryCollection). "\n";

        $data = current($countryCollection);
        if(is_object($data)) {
            $this->client->countries()->find($data->id);
        }
        $this->printLimit();
    }

    private function printLimit()
    {
        echo "Current rate limit is ". $this->client->getRateLimitRemaining(). "/". $this->client->getRateLimit(). ".\n";
    }
}
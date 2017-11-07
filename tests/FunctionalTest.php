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

    /**
     * @var integer
     */
    private static $seasonId;

    /**
     * @var integer
     */
    private static $teamId;

    /**
     * @var integer
     */
    private static $fixtureId;

    /**
     * @var integer
     */
    private static $homeTeamId;

    /**
     * @var integer
     */
    private static $awayTeamId;

    /**
     * @var integer
     */
    private static $venueId;

    /**
     * @var integer
     */
    private static $bookmakerId;

    /**
     * @var integer
     */
    private static $playerId;

    /**
     * @var integer
     */
    private static $roundId;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new HTTPClient();
        $this->client->setAuth(Auth::BASIC, [
            'token' => getenv('TOKEN')
        ]);
    }

    public function testBookmakers()
    {
        $collection = $this->client->bookmakers()->findAll();
        echo "Bookmakers ". count($collection). "\n";
        $data = current($collection);
        if(is_object($data)){
            self::$bookmakerId = $data->id;
            $this->client->bookmakers()->find($data->id);
        }
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
        $data = end($collection);
        if(is_object($data)) {
            self::$seasonId = $data->id;
            $this->client->seasons()->find($data->id);
            $this->client->seasons()->find($data->id, true);

            $roundCollection = $this->client->seasons()->rounds($data->id);
            $round = current($roundCollection);
            self::$roundId = $round->id;
            $this->client->seasons()->standings(self::$seasonId);
//        $this->client->seasons()->standingsLive(self::$seasonId);     // endpoint not supported by free plan
            $playerCollection = $this->client->seasons()->topScorers(self::$seasonId);
            $player = current($playerCollection->goalscorers->data);
            if(is_object($player)){
                self::$playerId = $player->player_id;
            }
        }
        $this->printLimit();
    }

    public function testRounds()
    {
        $this->client->rounds()->find(self::$roundId);
    }

    public function testPlayers()
    {
        $this->client->players()->find(self::$playerId);
    }

    public function testTeams()
    {
        $collection = $this->client->teams()->season(self::$seasonId);
        echo "Teams ". count($collection). "\n";
        $data = current($collection);
        if(is_object($data)){
            self::$teamId = $data->id;
            $this->client->teams()->find($data->id);
            $this->client->teams()->find($data->id, true);
        }
    }

    public function testSquad()
    {
        $collection = $this->client->squad()->getBySeasonAndTeam(self::$seasonId, self::$teamId);
        echo "Squad players ". count($collection). "\n";
        $this->printLimit();
    }

    public function testFixtures()
    {
        $startDate = new \DateTime();
        $startDate->sub(new \DateInterval('P10D')); // Get fixtures 10 days ago.
        $collection = $this->client->fixtures()->between()->period($startDate, new \DateTime('today'));
        $this->client->fixtures()->date()->day(new \DateTime('yesterday'));
        echo "Fixtures ". count($collection). "\n";
        $data = current($collection);
        if(is_object($data)) {
            self::$fixtureId = $data->id;
            self::$homeTeamId = $data->localteam_id;
            self::$awayTeamId = $data->visitorteam_id;
            self::$venueId = $data->venue_id;
            $this->client->fixtures()->between()->period(new \DateTime('yesterday'), new \DateTime('today'), $data->localteam_id);
            $this->client->fixtures()->find($data->id);
            $comments = $this->client->fixtures()->commentaries($data->id);
            echo "Comments ". count($comments). "\n";
            $this->client->fixtures()->videoHighlights($data->id);
            $this->client->fixtures()->tvStations($data->id);
            $this->client->fixtures()->oddsByBookmaker($data->id, self::$bookmakerId);
            $this->client->fixtures()->odds($data->id);
            $this->client->fixtures()->oddsByMarket($data->id, 1);     // I'm too lazy to get real marketId. Hope 1 is good alternative. :)
//            $this->client->fixtures()->oddsInPlay($data->id);       // endpoint not supported by free plan
        }
        $this->printLimit();
    }

    public function testVenue()
    {
        $this->client->venues()->find(self::$venueId);
    }

    public function testHead2Head()
    {
        $this->client->head2Head()->get([
            self::$homeTeamId,
            self::$awayTeamId
        ]);
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

    public function testLiveScores()
    {
        $collection = $this->client->liveScores()->today();
        $this->client->liveScores()->inPlay();
        echo "Today live scores (fixtures) ". count($collection). "\n";
        $this->printLimit();
    }

    public function testVideoHighlights()
    {
        $collection = [];
        do{
            $collection = array_merge($collection, $this->client->highlights()->findAll());
        }while($this->client->highlights()->nextPage());
        print_r(current($collection));
        echo "Video highlights ". count($collection). "\n";
    }

    private function printLimit()
    {
        echo "Current rate limit is ". $this->client->getRateLimitRemaining(). "/". $this->client->getRateLimit(). ".\n";
    }
}
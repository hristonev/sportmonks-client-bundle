<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:13
 */

namespace SportMonks\API\Resources;


use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Resource\FindAll;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class Fixtures
 * @package SportMonks\API\Resources
 *
 * @method FixturesBetween between()
 * @method FixturesDate date()
 */
class Fixtures extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * {@inheritdoc
     */
    public function find($id, array $params = [])
    {
        return $this->traitFind($id, $params);
    }

    /**
     * @param integer $fixtureId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function commentaries($fixtureId, array $params = [])
    {
        $this->setRoute('commentaries', 'commentaries/fixture/{fixture_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId
        ]);

        return $this->traitFind($fixtureId, $params, 'commentaries');
    }

    /**
     * @param integer $fixtureId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function videoHighlights($fixtureId, array $params = [])
    {
        $this->setRoute('highlights', 'highlights/fixture/{fixture_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId
        ]);

        return $this->traitFind($fixtureId, $params, 'highlights');
    }

    /**
     * @param integer $fixtureId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function tvStations($fixtureId, array $params = [])
    {
        $this->setRoute('tvStations', 'tvstations/fixture/{fixture_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId
        ]);

        return $this->traitFind($fixtureId, $params, 'tvStations');
    }

    public function odds($fixtureId, array $params = [])
    {
        $this->setRoute('odds_by_bookmaker', 'odds/fixture/{fixture_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId
        ]);

        return $this->traitFind($fixtureId, $params, 'odds_by_bookmaker');
    }

    public function oddsByBookmaker($fixtureId, $bookmakerId, array $params = [])
    {
        $this->setRoute('odds_by_bookmaker', 'odds/fixture/{fixture_id}/bookmaker/{bookmaker_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId,
            'bookmaker_id' => $bookmakerId
        ]);

        return $this->traitFind($fixtureId, $params, 'odds_by_bookmaker');
    }

    public function oddsByMarket($fixtureId, $marketId, array $params = [])
    {
        $this->setRoute('odds_by_market', 'odds/fixture/{fixture_id}/market/{market_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId,
            'market_id' => $marketId
        ]);

        return $this->traitFind($fixtureId, $params, 'odds_by_market');
    }

    public function oddsInPlay($fixtureId, array $params = [])
    {
        $this->setRoute('odds_in_play', 'odds/inplay/fixture/{fixture_id}');
        $this->setRouteParameters([
            'fixture_id' => $fixtureId
        ]);

        return $this->traitFind($fixtureId, $params, 'odds_in_play');
    }

    public static function getValidEndpoints()
    {
        return array_merge(parent::getValidEndpoints(), [
            'between' => FixturesBetween::class,
            'date' => FixturesDate::class
        ]);
    }
}
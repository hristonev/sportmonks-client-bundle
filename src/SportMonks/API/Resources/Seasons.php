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
use SportMonks\API\Traits\Resource\NextPage;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class Seasons
 * @package SportMonks\API\Resources
 */
class Seasons extends ResourceAbstract
{
    use InitTrait;

    use FindAll;

    use Find {
        find as traitFind;
    }

    use NextPage;

    /**
     * @param $id
     * @param bool $includeResults
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function find($id, $includeResults = false, array $params = [])
    {
        if($includeResults){
            $params = array_merge($params, [
                'query' => [
                    'include' => 'results'
                ]
            ]);
        }

        return $this->traitFind($id, $params);
    }

    /**
     * @param $seasonId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function standings($seasonId, array $params = [])
    {
        $this->setRoute('standings', 'standings/season/{season_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId
        ]);

        return $this->traitFind(null, $params, 'standings');
    }

    /**
     * @param $seasonId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function standingsLive($seasonId, array $params = [])
    {
        $this->setRoute('standings_live', 'standings/season/live/{season_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId
        ]);

        return $this->traitFind(null, $params, 'standings_live');
    }

    /**
     * @param $seasonId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function topScorers($seasonId, array $params = [])
    {
        $this->setRoute('top_scorers', 'topscorers/season/{season_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId
        ]);

        return $this->traitFind(null, $params, 'top_scorers');
    }

    /**
     * @param $seasonId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function rounds($seasonId, array $params = [])
    {
        $this->setRoute('rounds', 'rounds/season/{season_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId
        ]);

        return $this->traitFind(null, $params, 'rounds');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:13
 */

namespace SportMonks\API\Resources;


use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class Teams
 * @package SportMonks\API\Resources
 */
class Teams extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param $id
     * @param bool $includeStats
     * @param array $params
     *
     * @return array|null|\stdClass
     * @throws \SportMonks\API\Exceptions\MissingParameterException
     */
    public function find($id, $includeStats = false, array $params = [])
    {
        if($includeStats){
            $params = array_merge($params, [
                'query' => [
                    'include' => 'stats'
                ]
            ]);
        }

        return $this->traitFind($id, $params);
    }

    /**
     * @param integer $seasonId
     * @param array $params
     *
     * @return array|null|\stdClass
     * @throws \SportMonks\API\Exceptions\MissingParameterException
     */
    public function season($seasonId, array $params = [])
    {
        $this->setRoute('seasonTeams', 'teams/season/{season_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId
        ]);

        return $this->traitFind($seasonId, $params, 'seasonTeams');
    }
}
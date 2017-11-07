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
 * Class Squad
 * @package SportMonks\API\Resources
 */
class Squad extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param integer $seasonId
     * @param integer $teamId
     * @param array $params
     * @return array|null
     */
    public function getBySeasonAndTeam($seasonId, $teamId, $params = [])
    {
        $this->setRoute('squad_by_season_team', 'squad/season/{season_id}/team/{team_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId,
            'team_id' => $teamId
        ]);

        return $this->traitFind(null, $params, 'squad_by_season_team');
    }
}
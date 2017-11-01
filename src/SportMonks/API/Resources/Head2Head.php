<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:13
 */

namespace SportMonks\API\Resources;


use SportMonks\API\Exceptions\MissingParameterException;
use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class Head2Head
 * @package SportMonks\API\Resources
 */
class Head2Head extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param array $teams
     * @param array $params
     *
     * @return array|null|\stdClass
     *
     * @throws MissingParameterException
     */
    public function get(array $teams, array $params = [])
    {
        list($team1, $team2) = $teams;
        if((int)$team1 <= 0){
            throw new MissingParameterException(__METHOD__, ['team1']);
        }
        if((int)$team2 <= 0){
            throw new MissingParameterException(__METHOD__, ['team2']);
        }

        $this->setRoute('head2head', 'head2head/{team_1}/{team_2}');
        $this->setRouteParameters([
            'team_1' => $team1,
            'team_2' => $team2
        ]);

        return $this->traitFind(null, $params, 'head2head');
    }
}
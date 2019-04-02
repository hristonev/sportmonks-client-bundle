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
 * Class Rounds
 * @package SportMonks\API\Resources
 */
class Standings extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param integer $seasonId
     * @param array $params
     * @return array|null
     * @throws \SportMonks\API\Exceptions\MissingParameterException
     */
	public function getBySeason($seasonId, $params = [])
	{
		$this->setRoute('standings_by_season', 'standings/season/{season_id}');
			$this->setRouteParameters([
				'season_id' => $seasonId
			]);
	
			return $this->traitFind(null, $params, 'standings_by_season');
	}
}
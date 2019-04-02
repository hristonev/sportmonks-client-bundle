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
class Rounds extends ResourceAbstract
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
		$this->setRoute('round_by_season', 'rounds/season/{season_id}');
			$this->setRouteParameters([
				'season_id' => $seasonId
			]);
	
			return $this->traitFind(null, $params, 'round_by_season');
	}
}
<?php

namespace SportMonks\API\Resources;


use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class Stages
 * @package SportMonks\API\Resources
 * @author Hector Prats <hectorpratsortega@gmail.com>
 */
class Stages extends ResourceAbstract
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
     */
    public function find($id, $params = [])
    {
        return $this->traitFind($id, $params);
    }

    /**
     * @param integer $seasonId
     * @param array $params
     *
     * @return array|null|\stdClass
     */
    public function season($seasonId, array $params = [])
    {
        $this->setRoute('seasonStages', 'stages/season/{season_id}');
        $this->setRouteParameters([
            'season_id' => $seasonId
        ]);

        return $this->traitFind($seasonId, $params, 'seasonStages');
    }
}
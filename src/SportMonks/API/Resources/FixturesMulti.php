<?php

namespace SportMonks\API\Resources;


use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Resource\NextPage;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class FixturesBetween
 * @package SportMonks\API\Resources
 */
class FixturesMulti extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param array $idCollection
     * @param array $params
     *
     * @return null | array
     * @throws \SportMonks\API\Exceptions\MissingParameterException
     */
    public function period($idCollection, $params = [])
    {
        $this->setRoute('fixtures_multi', 'fixtures/multi/{ids}}');
        $this->setRouteParameters([
            'ids' => implode(',', $idCollection)
        ]);
        $params = array_merge($params, self::$param);

        return $this->traitFind(null, $params, 'fixtures_multi');
    }
}

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
 * Class FixturesBetween
 * @package SportMonks\API\Resources
 */
class FixturesBetween extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @param integer | null $teamId
     * @param array $params
     *
     * @return null | array
     */
    public function period(\DateTime $from, \DateTime $to, $teamId = null, $params = [])
    {
        if(is_null($teamId)) {
            $this->setRoute('fixtures_period', 'fixtures/between/{from}/{to}');
        }else{
            $this->setRoute('fixtures_period', 'fixtures/between/{from}/{to}/{team_id}');
        }
        $this->setRouteParameters([
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'team_id' => $teamId
        ]);

        return $this->traitFind(null, $params, 'fixtures_period');
    }
}
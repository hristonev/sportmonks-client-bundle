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
 * Class FixturesDate
 * @package SportMonks\API\Resources
 */
class FixturesDate extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * @param \DateTime $date
     * @param array $params
     *
     * @return null|\stdClass
     */
    public function day(\DateTime $date, $params = [])
    {
        $this->setRoute('fixtures_date', 'fixtures/date/{date}');
        $this->setRouteParameters([
            'date' => $date->format('Y-m-d')
        ]);

        return $this->traitFind(null, $params, 'fixtures_date');
    }
}
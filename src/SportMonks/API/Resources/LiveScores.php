<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:13
 */

namespace SportMonks\API\Resources;


use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Resource\NextPage;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class LiveScores
 * @package SportMonks\API\Resources
 */
class LiveScores extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    use NextPage;

    /**
     * @param array $params
     * @return array|null|\stdClass
     * @throws \SportMonks\API\Exceptions\MissingParameterException
     */
    public function today($params = [])
    {
        $this->setRoute('live_scores', 'livescores');

        return $this->traitFind(null, $params, 'live_scores');
    }

    /**
     * @param array $params
     * @return array|null|\stdClass
     * @throws \SportMonks\API\Exceptions\MissingParameterException
     */
    public function inPlay($params = [])
    {
        $this->setRoute('live_scores_now', 'livescores/now');

        return $this->traitFind(null, $params, 'live_scores_now');
    }
}
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
class Coaches extends ResourceAbstract
{
    use InitTrait;

    use Find {
        find as traitFind;
    }

    /**
     * {@inheritdoc
     */
    public function find($id, array $params = [])
    {
        return $this->traitFind($id, $params);
    }
}
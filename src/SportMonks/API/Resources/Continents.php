<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:13
 */

namespace SportMonks\API\Resources;


use SportMonks\API\Traits\Resource\Find;
use SportMonks\API\Traits\Resource\FindAll;
use SportMonks\API\Traits\Utility\InitTrait;

class Continents extends ResourceAbstract
{
    use InitTrait;

    use FindAll {
        findAll as traitFindAll;
    }

    use Find {
        find as traitFind;
    }

    public function findAll(array $params = [])
    {
        self::$response = $this->traitFindAll($params);

        return isset(self::$response->data) ? self::$response->data : null;
    }

    public static function getMetaData()
    {
        return isset(self::$response->meta) ? self::$response->meta : null;
    }
}
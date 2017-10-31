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

class Leagues extends ResourceAbstract
{
    use InitTrait;

    use FindAll {
        findAll as traitFindAll;
    }

    use Find {
        find as traitFind;
    }

    public function find($id, array $params = [])
    {
        self::$response = $this->traitFind($id, $params);

        return self::$response->data;
    }

    public function findAll(array $params = [])
    {
        self::$response = $this->traitFindAll($params);

        return self::$response->data;
    }

    public static function getMetaData()
    {
        return self::$response->meta ?? null;
    }
}
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
use SportMonks\API\Traits\Resource\NextPage;
use SportMonks\API\Traits\Utility\InitTrait;

/**
 * Class Countries
 * @package SportMonks\API\Resources
 */
class Countries extends ResourceAbstract
{
    use InitTrait;

    use FindAll;

    use Find;

    use NextPage;
}
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
 * Class Venues
 * @package SportMonks\API\Resources
 */
class Venues extends ResourceAbstract
{
    use InitTrait;

    use Find;
}
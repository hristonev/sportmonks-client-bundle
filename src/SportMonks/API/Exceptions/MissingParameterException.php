<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 12:45
 */

namespace SportMonks\API\Exceptions;


class MissingParameterException extends \Exception
{
    /**
     * @param string $method
     * @param array $params
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($method, array $params, $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            'Missing parameters: [' . implode(",", $params) . '] must be supplied for ' . $method,
            $code,
            $previous
        );
    }
}
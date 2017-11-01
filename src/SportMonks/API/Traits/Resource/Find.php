<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 10:03
 */

namespace SportMonks\API\Traits\Resource;


use SportMonks\API\Exceptions\MissingParameterException;
use SportMonks\API\Exceptions\RouteException;

trait Find
{
    /**
     * List all of this resource
     *
     * @param null $id
     * @param array $params
     * @param string $route
     *
     * @return null | array | \stdClass
     * @throws MissingParameterException
     */
    public function find($id = null, array $params = [], $route = __FUNCTION__)
    {
        try {
            $route = $this->getRoute($route, ['id' => $id]);
        } catch (RouteException $e) {
            if (! isset($this->resourceName)) {
                $this->resourceName = $this->getResourceNameFromClassName();
            }

            if(empty($id)){
                throw new MissingParameterException(__METHOD__, ['id']);
            }

            $route = $this->resourceName. '/'. $id;
            $this->setRoute(__FUNCTION__, $route);
        }

        self::$response = $this->client->get(
            $route,
            $params
        );

        return isset(self::$response->data) ? self::$response->data : null;
    }
}
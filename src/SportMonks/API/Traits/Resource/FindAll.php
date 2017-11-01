<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 10:03
 */

namespace SportMonks\API\Traits\Resource;


use SportMonks\API\Exceptions\RouteException;

trait FindAll
{
    /**
     * List all of this resource
     *
     * @param array $params
     * @param string $route
     *
     * @return null | array | \stdClass
     */
    public function findAll(array $params = [], $route = __FUNCTION__)
    {
        $params = array_merge($params, self::$param);

        try {
            $route = $this->getRoute($route, $params);
        } catch (RouteException $e) {
            if (! isset($this->resourceName)) {
                $this->resourceName = $this->getResourceNameFromClassName();
            }

            $route = $this->resourceName;
            $this->setRoute(__FUNCTION__, $route);
        }

        self::$response = $this->client->get(
            $route,
            $params
        );

        return isset(self::$response->data) ? self::$response->data : null;
    }
}
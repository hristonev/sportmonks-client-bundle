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
     * @return null|\stdClass
     * @throws MissingParameterException
     * @internal param string $routeKey
     */
    public function find($id = null, array $params = [], $route = __FUNCTION__)
    {
        if(empty($id)){
            throw new MissingParameterException(__METHOD__, ['id']);
        }

        try {
            $route = $this->getRoute($route, ['id' => $id]);
        } catch (RouteException $e) {
            if (! isset($this->resourceName)) {
                $this->resourceName = $this->getResourceNameFromClassName();
            }

            $route = $this->resourceName. '/'. $id;
            $this->setRoute(__FUNCTION__, $route);
        }

        return $this->client->get(
            $route,
            $params
        );
    }
}
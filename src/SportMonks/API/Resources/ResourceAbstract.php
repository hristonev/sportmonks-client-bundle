<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 31.10.17
 * Time: 08:12
 */

namespace SportMonks\API\Resources;


use SportMonks\API\Exceptions\RouteException;
use SportMonks\API\HTTPClient;

/**
 * Class ResourceAbstract
 * @package SportMonks\API\Resources
 */
abstract class ResourceAbstract
{
    /**
     * @var HTTPClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @var array
     */
    protected $routes;

    /**
     * @var array
     */
    protected $routeParameters = [];

    /**
     * @var \stdClass
     */
    protected static $response;

    protected static $param = [];

    public function __construct(HTTPClient $client)
    {
        $this->client = $client;

        if(!isset($this->resourceName)){
            $this->resourceName = $this->getResourceNameFromClassName();
        }
    }

    protected function getResourceNameFromClassName()
    {
        $classNamespaceName = get_class($this);
        $className = implode('', array_slice(explode('\\', $classNamespaceName), -1));

        // This converts the resource name from camel case to lower case.
        // Continents -> continents, InPlay -> inplay
        // Will be good to be underscored :)
        $resourceName = strtolower($className);

        return $resourceName;
    }

    /**
     * @return array
     */
    public static function getValidEndpoints()
    {
        return [];
    }

    public function setRoute($name, $route)
    {
        $this->routes[$name] = $route;
    }

    /**
     * Returns a route and replaces tokenized parts of the string with
     * the passed params
     *
     * @param string $name
     * @param array $params
     *
     * @return mixed
     * @throws \Exception
     */
    public function getRoute($name, array $params = [])
    {
        if (! isset($this->routes[$name])) {
            throw new RouteException('Route not found.');
        }

        $route = $this->routes[$name];

        $substitutions = array_merge($params, $this->getRouteParameters());
        foreach ($substitutions as $name => $value) {
            if (is_scalar($value)) {
                $route = str_replace('{' . $name . '}', $value, $route);
            }
        }

        return $route;
    }

    /**
     * @return array
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    /**
     * @param array $routeParameters
     */
    public function setRouteParameters(array $routeParameters)
    {
        $this->routeParameters = $routeParameters;
    }

    /**
     * @return null | array | \stdClass
     */
    public static function getMetaData()
    {
        return isset(self::$response->meta) ? self::$response->meta : null;
    }
}
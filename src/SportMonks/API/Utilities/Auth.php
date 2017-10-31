<?php
/**
 * Created by PhpStorm.
 * User: dimitar
 * Date: 30.10.17
 * Time: 19:27
 */

namespace SportMonks\API\Utilities;


use Psr\Http\Message\RequestInterface;
use SportMonks\API\Exceptions\AuthException;

class Auth
{
    /**
     * The authentication setting to use an token only
     */
    const BASIC = 'basic';

    /**
     * @var string $authMethod
     */
    protected $authMethod;

    /**
     * @var array $authOptions
     */
    protected $authOptions;

    protected static function getValidAuthenticationMethods()
    {
        return [
            self::BASIC
        ];
    }

    /**
     * Auth constructor.
     * @param $method
     * @param array $options
     *
     * @throws AuthException
     */
    public function __construct($method, array $options)
    {
        $this->authMethod = $method;
        $this->authOptions = $options;

        switch ($method){
            case self::BASIC:
                if (! array_key_exists('token', $options)) {
                    throw new AuthException('Please supply token for auth.');
                }
                break;
            default:
                throw new AuthException('Invalid auth method! Please use '
                    . implode(' | ', self::getValidAuthenticationMethods())
                );
        }
    }

    /**
     * @param RequestInterface $request
     * @param array $requestOptions
     *
     * @return array
     *
     * @throws AuthException
     */
    public function prepareRequest(RequestInterface $request, array $requestOptions = [])
    {
        switch ($this->authMethod){
            case self::BASIC:
                $requestOptions = array_merge($requestOptions, [
                    'query' => [
                        'api_token' => $this->authOptions['token']
                    ]
                ]);
                break;
            default:
                throw new AuthException('Please set authentication to send requests.');
        }

        return [$request, $requestOptions];
    }
}
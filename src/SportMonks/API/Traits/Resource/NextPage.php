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

trait NextPage
{
    /**
     * List all of this resource
     *
     * @return boolean
     * @throws MissingParameterException
     */
    public function nextPage($extra_params)
    {
        if(!property_exists(self::$response->meta, 'pagination')){
            return false;
        }
        $pagination = & self::$response->meta->pagination;

        $nextPage = $pagination->current_page + 1;
        if($nextPage > $pagination->total_pages){
            return false;
        }
		
	// Default Params
	$params = [
            'query' => [
                'page' => $nextPage
            ]
        ];
		
	// Merge new params in the call if exist
	if(!empty($extra_params))
	{
		$params['query'] = array_merge($extra_params['query'], $params['query']);
	}

        self::$param = array_merge(self::$param, $params);

        return true;
    }
}

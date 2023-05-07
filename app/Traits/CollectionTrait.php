<?php

namespace App\Traits;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

trait CollectionTrait
{
    use ResponseTrait;

    /**
     * Customize the response for a request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $excludedList = ['meta', 'links'];

        $data =  Arr::except($response->getData(true), $excludedList);
        $data['data'] = !empty($data['data']) ? $data['data'] : null;

        $response->setData($data);
    }
}

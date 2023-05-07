<?php

namespace App\Traits;

use App\Traits\ResponseTrait;

trait ResourceTrait
{
    use ResponseTrait;

    protected $success = true;
    protected $message;
    protected $_status;
    protected $errors;

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        if (empty($this->errors)) {
            return $this->responseErrors();
        }

        return $this->errors;
    }

    /**
     * Add errors field to the resource response.
     *
     * @param  array  $data
     * @return $this
     */
    public function errors(array $data = null)
    {
        $this->errors = $data;

        return $this;
    }

    /**
     * Customize the response for a request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $data = $response->getData(true);
        $data['data'] = !empty($data['data']) ? $data['data'] : null;

        $response->setData($data);
    }
}

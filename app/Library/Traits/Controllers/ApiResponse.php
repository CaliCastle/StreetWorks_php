<?php

namespace StreetWorks\Library\Traits\Controllers;

trait ApiResponse
{
    /**
     * Return success response.
     *
     * @param array|string $attributes
     * @param null         $to
     *
     * @return array
     * @author Cali
     */
    protected function successResponse($attributes = [], $to = null)
    {
        return $this->sendResponse(true, $attributes, $to);
    }

    /**
     * Return error response.
     *
     * @param array|string $attributes
     * @param null         $to
     *
     * @return array
     * @author Cali
     */
    protected function errorResponse($attributes = [], $to = null)
    {
        return $this->sendResponse(false, $attributes, $to);
    }

    /**
     * Send response accordingly.
     *
     * @param $success
     * @param $attributes
     * @param $to
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    protected function sendResponse($success, $attributes, $to)
    {
        $json = [];

        if ($this->shouldReturnJson()) {
            $json = $success ? $this->jsonSuccessResponse($attributes) : $this->jsonErrorResponse($attributes);
            return $json;
        }

        return $to ?
            redirect($to)->with($json) :
            redirect()->back()->with($json);
    }

    /**
     * Should return json response or not.
     *
     * @return bool
     * @author Cali
     */
    protected function shouldReturnJson()
    {
        return request()->ajax() || str_contains(request()->getUri(), 'api/');
    }

    /**
     * Return success response in json.
     *
     * @param array|string $attributes
     *
     * @return array
     * @author Cali
     */
    protected function jsonSuccessResponse($attributes)
    {
        return $this->jsonResponse(true, $attributes);
    }

    /**
     * Return error response in json.
     *
     * @param array|string $attributes
     *
     * @return array
     * @author Cali
     */
    protected function jsonErrorResponse($attributes)
    {
        return $this->jsonResponse(false, $attributes);
    }

    /**
     * Return json response.
     *
     * @param bool $success
     * @param array|string $attributes
     *
     * @return array
     * @author Cali
     */
    protected function jsonResponse($success, $attributes)
    {
        return is_string($attributes) ? [
            'status'  => $success ? 'success' : 'error',
            'message' => $attributes
        ] : array_merge(
            ['status' => $success ? 'success' : 'error'],
            $attributes
        );
    }
}
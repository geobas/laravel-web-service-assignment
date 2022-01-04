<?php

namespace App\Exceptions;

use App\Helpers\HttpStatus as Status;

/**
 * HTTP status 400 custom exception for external service errors.
 */
class ExternalService extends BaseException
{
    /**
     * Render the exception into a JSON response.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->api([
            'error' => $this->getMessage(),
        ], Status::BAD_REQUEST);
    }
}

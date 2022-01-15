<?php

namespace App\Exceptions;

use App\Helpers\HttpStatus as Status;

/**
 * HTTP status 500 custom exception for CRUD operations.
 */
class CrudException extends BaseException
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
            'error' => 'An error occured.',
        ], Status::INTERNAL_SERVER_ERROR);
    }
}

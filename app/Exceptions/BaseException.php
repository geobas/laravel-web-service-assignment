<?php

namespace App\Exceptions;

use Exception;
use ReflectionClass;
use Illuminate\Support\Facades\Log;

/**
 * Base exception to specify common functionality and methods.
 */
class BaseException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error((new ReflectionClass($this))->getShortName() . ': ' . $this->getMessage());
    }
}

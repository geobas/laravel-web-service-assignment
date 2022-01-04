<?php

namespace App\Exceptions;

use Log;
use Exception;
use ReflectionClass;

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

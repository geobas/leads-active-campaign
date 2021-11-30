<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Throwable;
use Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Log error.
     *
     * @param  Throwable  $t
     * @return void
     *
     * @throws \Exception|\Error
     */
    protected function logError(Throwable $t): void
    {
        Log::error("'" . $t->getMessage() . "' - File: '" . $t->getFile() . "' - Method: '" . 
            debug_backtrace()[1]['function'] . "' at line: " . $t->getLine());

        throw $t;
    }
}

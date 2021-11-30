<?php

namespace App\Exceptions;

use Log;
use Exception;
use ReflectionClass;
use Illuminate\Http\Request;
use App\Helpers\HttpStatus as Status;

class ActiveCampaignService extends Exception
{
    /**
     * Render the exception into a JSON response.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        return response()->api([
            'error' => $this->getMessage(),
        ], Status::BAD_REQUEST);
    }

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

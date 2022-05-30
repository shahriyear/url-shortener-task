<?php

namespace App\Traits;

use Illuminate\Support\Facades\URL;

trait ResponseTrait
{
    public function alreadyExitsResponse($hash)
    {
        return response()->json([
            'message' => 'Link is already exists!',
            'url' => URL::to('/' . $hash)
        ]);
    }

    public function successResponse($hash)
    {
        return response()->json([
            'message' => 'Link is successfully shorted!',
            'url' => URL::to('/' . $hash)
        ]);
    }

    public function notSateResponse()
    {
        return response()->json([
            'errors' => [
                'url' => ['Please enter a safe url!'],
            ]
        ], 422);
    }

    public function internalServerError()
    {
        return response()->json([
            'errors' => [
                'message' => ['Something went wrong!'],
            ]
        ], 500);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateUrlRequest;
use App\Models\Url;
use App\Services\SafeBrowsingService;
use App\Traits\ResponseTrait;
use App\Traits\StringTrait;
use Exception;

class UrlShortenerApiController extends Controller
{

    use StringTrait, ResponseTrait;

    /**
     * Store the url and check if exists return  
     *
     * @param GenerateUrlRequest $request
     * @return void
     */
    public function store(GenerateUrlRequest $request)
    {
        $rtrim = rtrim($request->url, '/');

        try {
            $safe = (new SafeBrowsingService($rtrim))->request();
            if (!empty($safe)) {
                return $this->notSateResponse();
            }

            $encodedUrl = urlencode($rtrim);

            $data = Url::where("url", $encodedUrl)->first();

            if ($data) {
                return $this->alreadyExitsResponse($data->hash);
            }

            $url = new Url();
            $url->url = $encodedUrl;
            $url->hash = $this->getUniqueStringInUrlHash();
            $url->save();

            return $this->successResponse($url->hash);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }
}

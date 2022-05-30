<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class RedirectOriginalUrlController extends Controller
{
    public function redirectByHash(string $hash)
    {
        $data = Url::where("hash", "=", $hash)->first();
        abort_if(is_null($data), 404);
        return redirect()->away(urldecode($data->url));
    }
}

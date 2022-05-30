<?php

namespace App\Traits;

use App\Models\Url;

trait StringTrait
{

    /**
     * generate a random string and go though db for check its unique 
     *
     * @return void
     */
    public function getUniqueStringInUrlHash(): string
    {
        $string = "0123456789abcdefghijklmnopqrstvwxyz";

        do {
            $hash = substr(str_shuffle($string), 0, 6);
        } while (Url::where("hash", "=", $hash)->first());

        return $hash;
    }
}

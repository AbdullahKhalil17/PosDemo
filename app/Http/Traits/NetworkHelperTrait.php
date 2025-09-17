<?php

namespace App\Http\Traits;

trait NetworkHelperTrait
{
    /**
     * Check if there is an active internet connection.
     *
     * @param string $site The site to check the connection against.
     * @return bool
     */
    protected function isConnected($site = "www.google.com"): bool
    {
        return (bool) @fsockopen($site, 80, $errno, $errstr, 5);
    }
}
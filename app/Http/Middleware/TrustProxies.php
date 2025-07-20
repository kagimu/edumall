<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    protected $proxies = '*'; // Trust all proxies (Railway, Netlify, etc)

    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}

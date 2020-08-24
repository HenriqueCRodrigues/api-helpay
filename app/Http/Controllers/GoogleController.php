<?php

namespace App\Http\Controllers;

use App\Services\GoogleApiService;

class GoogleController extends Controller
{
    public function __construct()
    {
        $this->googleApiService = new GoogleApiService();
    }

    public function callback() {
        return $this->googleApiService->setConfigClient();
    }
}

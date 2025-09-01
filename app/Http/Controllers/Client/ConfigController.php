<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientConfiguration;

class ConfigController extends Controller
{
    public function getConfiguration()
    {
        $config = ClientConfiguration::first();

        return response()->json([
            'data' => $config
        ]);
    }
}

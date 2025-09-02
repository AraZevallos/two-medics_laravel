<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientConfiguration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function getConfiguration()
    {
        $config = ClientConfiguration::first();

        if ($config->image_path) {
            try {
                $fileContent = Storage::disk('r2')->get($config->image_path);

                $mime = Storage::disk('r2')->mimeType($config->image_path);

                $config->image_path = "data:{$mime};base64," . base64_encode($fileContent);
            } catch (\Exception $e) {
                Log::error('Error obteniendo imagen desde R2: ' . $e->getMessage());
            }
        }

        return response()->json([
            'data' => $config
        ]);
    }
}

<?php

namespace App\Http\Controllers\ClientConfigurations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\ClientConfiguration;

class ClientConfigurationController extends Controller
{
    public function index()
    {
        $configuration = ClientConfiguration::first();

        // Si existe imagen en la config, la cargamos desde R2 y la convertimos a base64
        $imageBase64 = null;
        if ($configuration->image_path) {
            try {
                $fileContent = Storage::disk('r2')->get($configuration->image_path);

                $mime = Storage::disk('r2')->mimeType($configuration->image_path);

                $imageBase64 = "data:{$mime};base64," . base64_encode($fileContent);
            } catch (\Exception $e) {
                Log::error('Error obteniendo imagen desde R2: ' . $e->getMessage());
            }
        }

        return Inertia::render('configs/Configurations', [
            'configuration' => $configuration,
            'imageBase64'   => $imageBase64,
        ]);
    }


    public function updateImageSection(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        $configuration = ClientConfiguration::first();

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $key = $file->store('promotional', 'r2');

            if ($configuration->image_path) Storage::disk('r2')->delete($configuration->image_path);

            $configuration->image_path = $key;
            $configuration->image_name = $file->getClientOriginalName();
        }

        $configuration->save();

        return $this->index();
    }

    public function deleteImageSection()
    {
        $configuration = ClientConfiguration::first();

        Storage::disk('r2')->delete($configuration->image_path);

        $configuration->image_path = null;
        $configuration->image_name = null;
        $configuration->save();

        return $this->index();
    }

    public function updateSocialsSection(Request $request)
    {
        $configuration = ClientConfiguration::first();

        $socials = ['tiktok', 'whatsapp', 'telegram', 'correo'];

        foreach ($socials as $social)
            if ($request->has($social)) $configuration->{$social} = $request->input($social);

        $configuration->save();

        return $this->index();
    }

    public function updateDynamicQuestionsSection(Request $request)
    {
        $configuration = ClientConfiguration::first();

        $configuration->question = $request->input('question');
        $configuration->answer = $request->input('answer');
        $configuration->explanation = $request->input('explanation');

        $configuration->save();

        return $this->index();
    }
}

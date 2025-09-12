<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CursoController extends Controller
{
    public function downloadByCode(string $code)
    {
        $codigoModel = Code::with('course.files', 'course.children.files')
            ->where('value', $code)
            ->first();

        if (!$codigoModel) {
            abort(404, 'Código no encontrado');
        }

        $course = $codigoModel->course;

        // Path temporal para el zip
        $zipFileName = $course->name . uniqid() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {

            if ($course->parent_id === null) {
                // Es un parent → agregar hijos visibles
                foreach ($course->children as $child) {
                    if ($child->is_visible) {
                        foreach ($child->files as $file) {
                            $fileContent = Storage::disk('r2')->get($file->file_path);
                            if ($fileContent !== false) {
                                $zip->addFromString(
                                    $child->name . '/' . basename($file->file_name),
                                    $fileContent
                                );
                            }
                        }
                    }
                }
            } else {
                // Es un child → solo sus archivos
                foreach ($course->files as $file) {
                    $fileContent = Storage::disk('r2')->get($file->file_path);
                    if ($fileContent !== false) {
                        $zip->addFromString(
                            basename($file->file_name),
                            $fileContent
                        );
                    }
                }
            }

            $zip->close();
        }

        // Preparar respuesta
        $response = response()->download($zipPath)->deleteFileAfterSend(true);

        // Si el código NO es persistente → eliminarlo después de enviar
        if (!$codigoModel->is_persistent) $codigoModel->delete();

        return $response;
    }
}

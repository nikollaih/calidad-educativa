<?php

namespace App\Http\Services;

use App\Models\Adjunto;
use App\DTOs\Result;
use Illuminate\Http\UploadedFile;

class AdjuntoService {
    // Permite almacenar un adjunto
    public function storeAdjunto(UploadedFile $adjunto, string $ruta, string $disk = 'public'):Result {
             $adjuntoInfo = [];

             // Obtener la extensión original del archivo
             $adjuntoInfo['extension']        = $adjunto->getClientOriginalExtension();
             // Obtiene el nombre del archivo
             $adjuntoInfo['nombre']           =  pathinfo($adjunto->getClientOriginalName(), PATHINFO_FILENAME);
             // Obtiene el nombre completo del archivo
             $adjuntoInfo['nombre_completo']  =  $adjunto->getClientOriginalName();
             // Obtiene el tipo MIME del archivo
             $adjuntoInfo['tipo_mime']             = $adjunto->getClientMimeType();
             // Obtiene el disco del archivo
             $adjuntoInfo['disco']             = $disk;

             // Generar un nombre único
             $nombreUnico = $adjuntoInfo['nombre'] . '_' . uniqid() . '.' . $adjuntoInfo['extension'];

             // Guardar archivo
             $rutaArchivo = $adjunto->storeAs($ruta, $nombreUnico, $disk);

             if ($rutaArchivo) {
                $adjuntoInfo['ruta'] = $rutaArchivo;
                $adjuntoCreated = Adjunto::create($adjuntoInfo);
                return Result::success(msg:'Archivo guardado exitosamente',data: $adjuntoCreated);
             }
            return Result::error(msg:'Error al guardar el archivo');
    }
    public  function storeFavicon(UploadedFile $favicon): Result
    {
        try {
            // Validar que el archivo sea una imagen
            if (!$favicon->isValid()) {
                return Result::error(msg: 'El archivo no es válido');
            }
            // Validar tipo de archivo (opcional)
            $allowedMimes = ['image/x-icon', 'image/vnd.microsoft.icon'];
            if (!in_array($favicon->getMimeType(), $allowedMimes)) {
                return Result::error(msg: 'El archivo debe ser un favicon válido (.ico, .png, .jpg, .gif) , el formato enviado es ' .  $favicon->getMimeType());
            }

            // Definir la ruta de destino
            $destinationPath = public_path('assets/img/favicon');
            $fileName = 'favicon.ico';
            $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;

            // Crear el directorio si no existe
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Eliminar el archivo existente si existe
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Mover el archivo a la ruta de destino
            $favicon->move($destinationPath, $fileName);

            return Result::success(msg: 'Logo guardado exitosamente', data: null);

        } catch (\Exception $e) {
            return Result::error(msg: 'Error al guardar el logo: ' . $e->getMessage());
        }
    }
    public function storeLogo(UploadedFile $logo): Result
    {
        try {
            // Validar que el archivo sea una imagen
            if (!$logo->isValid()) {
                return Result::error(msg: 'El archivo no es válido');
            }

            // Validar tipo de archivo (opcional)
            $allowedMimes = ['image/png', 'image/jpeg', 'image/pjpeg', 'image/gif'];
            if (!in_array($logo->getMimeType(), $allowedMimes)) {
                return Result::error(msg: 'El archivo debe ser un logo válido png, el formato enviado es ' .  $logo->getMimeType());
            }

            // Definir la ruta de destino
            $destinationPath = public_path('imagenes');
            $fileName = 'educacion_menu-nobg.png';
            $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;

            // Crear el directorio si no existe
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Eliminar el archivo existente si existe
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Mover el archivo a la ruta de destino
            $logo->move($destinationPath, $fileName);

            return Result::success(msg: 'Logo guardado exitosamente', data: null);

        } catch (\Exception $e) {
            return Result::error(msg: 'Error al guardar el logo: ' . $e->getMessage());
        }
    }

}

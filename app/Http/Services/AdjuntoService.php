<?php

namespace App\Http\Services;

use App\Models\Adjunto;
use Illuminate\Http\UploadedFile;

class AdjuntoService {
    // Permite almacenar un adjunto
    public function storeAdjunto(UploadedFile $adjunto, string $ruta, string $disk = 'public') {
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
                return ['msg' => 'Archivo guardado exitosamente', 'success' => true, 'content' => $adjuntoCreated];
             }
            return ['msg' => 'Error al guardar el archivo', 'success' => false, 'content' => null];
    }

}

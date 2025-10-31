<?php

namespace App\Http\Services\PMI;

use App\Models\PMI\PmiMeta;
use App\Models\PMI\PmiObjetivo;
use App\Models\PmiMetaVinculada;
use App\Models\PmiObjetivoVinculado;

class PmiMetasVinculadasService {
    public function __construct(private PmiIndicadorVinculadoService $pmiIndicadorVinculadoService ,private PmiActividadVinculadasService $pmiActividadVinculadasService) {
    }

    public function syncMetasVinculados(array $metasArray, int $idObjetivo): void {
        $ids = [];
        // Recorre los registros
        foreach ($metasArray as $key => $meta) {
            $cannotCreateOrUpdate = !is_array($meta) ||
                empty($meta) ||
                empty($meta['descripcion']);

            if ($cannotCreateOrUpdate) {
                continue;
            }
            $meta['objetivo_id'] = $idObjetivo;
            $metaId = (isset($meta['id']) && strpos($meta['id'], 'virtual') === false)
                ? $meta['id']
                : null;

            if ($metaId == null) {
                unset($meta['id']);
            }
            // Syncroniza el registro
            $metaUpdated = PmiMetaVinculada::updateOrCreate(['id' => $metaId], $meta);
            if ($metaId == null && request()->input('institucionId') != null) {
                $institucionId = request()->input('institucionId');
                $objetivoVinculado = PmiObjetivoVinculado::findOrFail($metaUpdated->objetivo_id);
                $objetivoParametrizado = PmiObjetivo::where('descripcion', $objetivoVinculado->descripcion)
                    ->where(function ($query) use ($institucionId) {
                        $query->whereNull('institucion_id')
                            ->orWhere('institucion_id', $institucionId);
                    })
                    ->first();
                if (!empty($objetivoParametrizado)) {
                    // Verificar si ya existe uno con mismo descripcion + indice_calificacion
                    // con institucion_id NULL o exactamente el mismo institucion_id
                    $existe = PmiMeta::where('descripcion', $metaUpdated->descripcion)
                        ->where('objetivo_id', $objetivoParametrizado->id)
                        ->exists();
                    // Si no existe, lo creamos
                    if (!$existe) {
                        PmiMeta::create([
                            'descripcion'  => $metaUpdated->descripcion,
                            'indicador_id' => $metaUpdated->indicador_id,
                            'objetivo_id'  => $objetivoParametrizado->id,
                        ]);
                    }
                }
            }
            $this->pmiIndicadorVinculadoService->syncIndicadoresVinculados(indicadoresArray: $meta['indicadores'], idMeta:  $metaUpdated->id);
            array_push($ids, $metaUpdated->id);
        }
        // Elimina los sobrantes
        PmiMetaVinculada::where('objetivo_id', $idObjetivo)->whereNotIn('id', $ids)->delete();
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdatePeiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            // 'basic_info' => [
            //     'id' => $this->id,
            //     'nombre' => $this->nombre,
            //     'nit' => $this->nit,
            //     'dane' => $this->dane,
            //     'email' => $this->email,
            //     'telefono' => $this->telefono,
            //     'web_url' => $this->web_url,
            //     'nombre_rector' => $this->nombre_rector,
            //     'nombre_coordinadores' => $this->nombre_coordinadores,
            //     'licencia_funcionamiento' => $this->licencia_funcionamiento,
            // ],
            
            'gestion_directiva' => $this->transformGestion($this->gestionDirectiva, [
                'climaEscolar',
                'culturaInstitucional',
                'direccionamientoEstrategico',
                'gestionEstrategica',
                'gobiernoEscolar',
                'relacionesEntorno'
            ]),
            
            'gestion_academica' => $this->transformGestion($this->gestionAcademica, [
                'gestionAulas',
                'practicasPedagogicas',
                'seguimientosAcademicos',
                'disenosPedagogicos',
            ]),
            
            'gestion_administrativa' => $this->transformGestion($this->gestionAdministrativa, [
                'administracionPlantaFisica',
                'apoyoFinancieroContable',
                'apoyoGestionAcademica',
                'serviciosComplementarios',
                'talentoHumano'
            ]),
            
            'gestion_comunidad' => $this->transformGestion($this->gestionComunidad, [
                'atencionGrupoPoblacionales',
                'prevencionRiesgos',
                'programasServicioSocial'
            ]),
        ];
    }

    protected function transformGestion($gestion, array $relations): ?array
    {
        if (!$gestion) {
            return null;
        }

        $transformed = [];
        
        foreach ($relations as $relation) {
            if ($gestion->relationLoaded($relation)) {
                $transformed[$relation] = $gestion->{$relation};
            }
        }
        
        // Add documents if they exist
        if (isset($gestion->documentos)) {
            $transformed['documentos'] = $gestion->documentos;
        }
        
        return $transformed;
    }
}

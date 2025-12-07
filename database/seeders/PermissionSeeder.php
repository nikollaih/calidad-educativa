<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Crear permisos
        $permissions = [
            ['name'=>'hr-usuario-ver'],
            ['name'=>'hr-usuario-crear'],
            ['name'=>'hr-usuario-editar'],
            ['name'=>'hr-usuario-eliminar'],
            ['name'=>'s-role-ver'],
            ['name'=>'s-role-crear'],
            ['name'=>'s-role-editar'],
            ['name'=>'s-role-eliminar'],
            
            // Permisos
            ['name'=>'s-permission-ver'],
            ['name'=>'s-permission-crear'],
            ['name'=>'s-permission-editar'],
            ['name'=>'s-permission-eliminar'],

            // Instituciones
            ['name'=>'s-institucion-ver'],
            ['name'=>'s-institucion-crear'],
            ['name'=>'s-institucion-editar'],
            ['name'=>'s-institucion-eliminar'],

            // Municipios
            ['name'=>'s-municipio-ver'],
            ['name'=>'s-municipio-crear'],
            ['name'=>'s-municipio-editar'],
            ['name'=>'s-municipio-eliminar'],

            // Ajustes
            ['name'=>'s-ajuste-ver'],
            ['name'=>'s-ajuste-crear'],
            ['name'=>'s-ajuste-editar'],
            ['name'=>'s-ajuste-eliminar'],

            // Modelos Educacionales
            ['name'=>'s-modelo-educacional-ver'],
            ['name'=>'s-modelo-educacional-crear'],
            ['name'=>'s-modelo-educacional-editar'],
            ['name'=>'s-modelo-educacional-eliminar'],

            // Modelos Pedagogicos
            ['name'=>'s-modelo-pedagogico-ver'],
            ['name'=>'s-modelo-pedagogico-crear'],
            ['name'=>'s-modelo-pedagogico-editar'],
            ['name'=>'s-modelo-pedagogico-eliminar'],

            // Redes de Aprendizaje
            ['name'=>'s-red-aprendizaje-ver'],
            ['name'=>'s-red-aprendizaje-crear'],
            ['name'=>'s-red-aprendizaje-editar'],
            ['name'=>'s-red-aprendizaje-eliminar'],

            // Unidades Meta (Indicadores PAM)
            ['name'=>'s-unidad-meta-ver'],
            ['name'=>'s-unidad-meta-crear'],
            ['name'=>'s-unidad-meta-editar'],
            ['name'=>'s-unidad-meta-eliminar'],

            // Componentes PAM
            ['name'=>'s-componente-ver'],
            ['name'=>'s-componente-crear'],
            ['name'=>'s-componente-editar'],
            ['name'=>'s-componente-eliminar'],

            // Objetivos PMI
            ['name'=>'s-objetivo-pmi-ver'],
            ['name'=>'s-objetivo-pmi-crear'],
            ['name'=>'s-objetivo-pmi-editar'],
            ['name'=>'s-objetivo-pmi-eliminar'],

            // Indicadores PMI
            ['name'=>'s-indicador-pmi-ver'],
            ['name'=>'s-indicador-pmi-crear'],
            ['name'=>'s-indicador-pmi-editar'],
            ['name'=>'s-indicador-pmi-eliminar'],

            // Redes Pedagogicas (Actividades)
            ['name'=>'s-red-actividad-ver'],
            ['name'=>'s-red-actividad-crear'],
            ['name'=>'s-red-actividad-editar'],
            ['name'=>'s-red-actividad-eliminar'],

            // Validacion PMI
            ['name'=>'s-pmi-validacion-ver'],
            ['name'=>'s-pmi-validacion-crear'],
            ['name'=>'s-pmi-validacion-editar'],
            ['name'=>'s-pmi-validacion-eliminar'],

            // Parámetros del Sistema (Permiso Unificado)
            ['name'=>'s-parametro-editar'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission,$permission);
        }
    }
}

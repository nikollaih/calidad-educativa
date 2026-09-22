@extends('layouts.app')

@section('content')
    <div
        data-component="CInstitutionNavigations"
        data-back-url="{{ route('proyectos-transversales.index', $institucionId) }}"
        data-detail-url="{{ route('institution.show', $institucionId) }}"
        data-pei-url="{{ route('institution.pei.update-pei', $institucionId) }}"
        data-autevaluacion-url="{{ route('institution.autoevaluaciones', $institucionId) }}"
        data-pmi-url="{{ route('pmi.index', $institucionId) }}"
        data-proyectos-transversales-url="#"
    >
    </div>
    <div
        data-component="ListaProyectoTransversalActividades"
        data-csrf-token="{{ csrf_token() }}"
        data-proyecto-transversal-id='{!! json_encode($proyectoTransversal) !!}'
        data-is-related-to-proyecto='{!! json_encode($isRelatedToProyecto) !!}'
        data-actividades='{!! json_encode($actividades) !!}'
        data-integrantes='{!! json_encode($integrantes) !!}'
        data-detalle-proyecto='{!! json_encode($detalleProyecto) !!}'
        data-agregar-url="{{ route('proyecto-transversal-actividades.store', $proyectoTransversal) }}">
    </div>
@endsection

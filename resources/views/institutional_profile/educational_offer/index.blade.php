@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    ></div>
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <h1 class="card-header">Ofertas educativas</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('educational-offer.create') }}" class="border bg-blue-500  text-white p-2 rounded-pill mb-3">Crear oferta educativa</a>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>¿TIENE AUTORIZACIÓN PARA VALIDACIÓN DE ESTUDIOS?</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($paginate as $educationalOffer)
                            <tr>
                                <td> {{ $educationalOffer->name }} </td>
                                 @isset($educationalOffer->validationAuthorizationAdjunto)
                                    @if($educationalOffer->validationAuthorizationAdjunto?->url)
                                        <td>
                                            <a href="{{ $educationalOffer->validationAuthorizationAdjunto->url }}"
                                               target="_blank"
                                               class="btn btn-outline-info btn-sm"
                                               title="Ver adjunto">
                                                <i class="fas fa-eye"></i> Si, ver adjunto
                                            </a>

                                        </td>
                                    @else
                                        <td>
                                            <span class="text-danger" title="Archivo no accesible">
                                                <i class="fas fa-exclamation-circle"></i> Error
                                            </span>
                                        </td>
                                    @endif
                                @else
                                        <td>
                                    No
                                        </td>
                                @endisset
                                <td>
                                    <a href="{{ route('educational-offer.edit', $educationalOffer->id) }}" class="border bg-blue-500  text-white p-2 rounded-pill btn-sm">Editar</a>
                                    <form action="{{ route('educational-offer.destroy', $educationalOffer->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border bg-blue-500  text-white p-2 rounded-pill btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                       </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

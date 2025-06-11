@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
        data-to="{{asset("/dashboard")}}"
    >
    </div>

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="fw-bold text-dark mb-1">Configuración del Sistema</h2>
                </div>

                <!-- Card Principal -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h4 class="card-title  mb-0 d-flex align-items-center text-black">
                            <i class="fas fa-palette me-2"></i>
                            Aspecto del Sistema
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Sección Favicon -->
                            <div class="col-md-6">
                                <div class="border rounded-3 p-4 h-100" style="background: linear-gradient(145deg, #f8f9ff 0%, #e6e9f4 100%);">
                                    <div class="text-center mb-3">
                                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 80px; height: 80px;">
                                            <i class="fas fa-star text-primary" style="font-size: 2rem;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Favicon</h5>
                                        <p class="text-muted small mb-3">Icono que aparece en la pestaña del navegador</p>
                                    </div>


                                    <!-- Botón de subida -->
                                    <div class="d-grid">
                                        <button class="btn btn-outline-primary btn-lg rounded-pill" type="button">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            Subir Favicon
                                        </button>
                                    </div>

                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recomendado: 32x32px, formato .ico o .png
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Logo -->
                            <div class="col-md-6">
                                <div class="border rounded-3 p-4 h-100" style="background: linear-gradient(145deg, #fff8f0 0%, #f4e6d9 100%);">
                                    <div class="text-center mb-3">
                                        <div class="bg-white rounded-3 d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 120px; height: 80px;">
                                            <div class="text-center">
                                                <i class="fas fa-building text-warning" style="font-size: 1.5rem;"></i>
                                                <div class="small fw-bold text-dark mt-1">LOGO</div>
                                            </div>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Logo Principal</h5>
                                        <p class="text-muted small mb-3">Logo que aparece en la aplicación</p>
                                    </div>

                                    <!-- Botón de subida -->
                                    <div class="d-grid">
                                        <button class="btn btn-outline-warning btn-lg rounded-pill" type="button">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            Subir Logo
                                        </button>
                                    </div>

                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recomendado: 300x100px, formato .png o .svg
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-success rounded-pill px-4">
                                    <i class="fas fa-save me-2"></i>
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .border {
            border-color: #e9ecef !important;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@endsection

@extends('layouts.app')

@section('content')

    @php
        $kpiCards = [
            [
                'label'  => 'Instituciones',
                'value'  => $stats['instituciones'] ?? 0,
                'sub'    => null,
            ],
            [
                'label'  => 'Sedes',
                'value'  => $stats['sedes'] ?? 0,
                'sub'    => null,
            ],
            [
                'label'  => 'Prom. sedes / Institución',
                'value'  => $stats['promedio_sedes_por_institucion'] ?? 0,
                'sub'    => null,
            ],
            [
                'label'  => 'PMIs Totales',
                'value'  => $stats['pmi_total'] ?? 0,
                'sub'    => null,
            ],
            [
                'label'  => 'PMIs Aprobados',
                'value'  => $stats['pmi_aprobados'] ?? 0,
                'sub'    => ($stats['porc_aprobados'] ?? 0) . '%',
            ],
            [
                'label'  => 'PMIs Presentados',
                'value'  => $stats['pmi_presentados'] ?? 0,
                'sub'    => ($stats['porc_presentados'] ?? 0) . '%',
            ],
            [
                'label'  => 'Autoev. en Proceso',
                'value'  => $stats['autoevaluaciones_proceso'] ?? 0,
                'sub'    => null,
            ],
            [
                'label'  => 'Autoev. en Validación',
                'value'  => $stats['autoevaluaciones_validacion'] ?? 0,
                'sub'    => null,
            ],
        ];

        $chartCards = [
            [
                'title'     => 'Distribución de PMI por estado',
                'id'        => 'chart-pmi-estado',
                'col_class' => 'col-12 col-xl-6',
            ],
            [
                'title'     => 'Autoevaluaciones por estado',
                'id'        => 'chart-autoevaluaciones-estado',
                'col_class' => 'col-12 col-xl-6',
            ],
            [
                'title'     => 'Top municipios por instituciones',
                'id'        => 'chart-instituciones-municipio',
                'col_class' => 'col-12',
            ],
        ];
    @endphp

    <div class="row g-3">
        {{-- ── Título sección ── --}}
        <div class="col-12">
            <h5 class="mb-1 text-custom-blue-dark">INFORMACIÓN GENERAL</h5>
        </div>
        {{-- ── KPI Cards ── --}}
        @foreach ($kpiCards as $kpi)
            <div class="col-6 col-sm-4 col-xl-3 d-flex">
                <div class="!border border-custom-blue-light rounded-xl bg-white h-100 w-100">
                    <div class="card-body py-3 px-3">
                        <p class="!text-custom-blue-dark  kpi-label mb-1 ">{{ $kpi['label'] }}</p>
                        <h4 class="kpi-value mb-0">{{ $kpi['value'] }}</h4>
                        @if ($kpi['sub'])
                            <small class="text-muted">{{ $kpi['sub'] }}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- ── Chart Cards ── --}}
        @foreach ($chartCards as $chart)
            <div class="{{ $chart['col_class'] }} d-flex">
                <div class="!border border-custom-blue-light bg-white rounded-xl chart-card h-100 w-100">
                    <div class="card-header py-3 px-4">
                        <h6 class="mb-0 text-custom-blue-dark">{{ $chart['title'] }}</h6>
                    </div>
                    <div class="card-body p-2">
                        <div id="{{ $chart['id'] }}"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection

@section('vendors_css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('custom_css')
    <style>
        .kpi-card          { min-height: 100px; }
        .kpi-card .card-body { display: flex; flex-direction: column; justify-content: center; }
        .kpi-label         { font-size: .78rem; color: #6c757d; font-weight: 500; }
        .kpi-value         { font-size: 1.6rem; font-weight: 700; }
        .chart-card        { min-height: 380px; }
        #chart-pmi-estado,
        #chart-autoevaluaciones-estado,
        #chart-instituciones-municipio { min-height: 300px; }
    </style>
@endsection
@section('javascripts')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
        (function () {
            const chartDataPmi   = @json($charts['pmi_por_estado']               ?? ['labels' => [], 'series' => []]);
            const chartDataMun   = @json($charts['instituciones_por_municipio']   ?? ['labels' => [], 'series' => []]);
            const chartDataAuto  = @json($charts['autoevaluaciones_por_estado']   ?? ['labels' => [], 'series' => []]);

            // ── Helpers ───────────────────────────────────────────────────────────────
            function donut(selector, data) {
                new ApexCharts(document.querySelector(selector), {
                    series      : data.series || [],
                    labels      : data.labels  || [],
                    chart       : { type: 'donut', height: 300 },
                    legend      : { position: 'bottom' },
                    dataLabels  : { enabled: true },
                }).render();
            }

            function bar(selector, data, seriesName) {
                new ApexCharts(document.querySelector(selector), {
                    series      : [{ name: seriesName, data: data.series || [] }],
                    chart       : { type: 'bar', height: 300, toolbar: { show: false } },
                    xaxis       : { categories: data.labels || [] },
                    plotOptions : { bar: { borderRadius: 6, columnWidth: '45%' } },
                    dataLabels  : { enabled: false },
                }).render();
            }

            // ── Render ────────────────────────────────────────────────────────────────
            donut('#chart-pmi-estado',               chartDataPmi);
            donut('#chart-autoevaluaciones-estado',  chartDataAuto);
            bar  ('#chart-instituciones-municipio',  chartDataMun, 'Instituciones');
        })();
    </script>
@endsection

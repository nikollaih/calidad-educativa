@extends('layouts.app')

@section('content')

<div class="row g-4">
    <div class="col-12">
        <h4 class="mb-3">Información general</h4>
    </div>

    <!-- Fila 1: KPIs numéricos -->
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">Instituciones</span>
                <h3 class="card-title mb-2">{{ $stats['instituciones'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">Sedes</span>
                <h3 class="card-title mb-2">{{ $stats['sedes'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">Prom. sedes/Institución</span>
                <h3 class="card-title mb-2">{{ $stats['promedio_sedes_por_institucion'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">PMIs Totales</span>
                <h3 class="card-title mb-2">{{ $stats['pmi_total'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <!-- Fila 2: KPIs numéricos -->
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">PMIs Aprobados</span>
                <h3 class="card-title mb-2">{{ $stats['pmi_aprobados'] ?? 0 }}</h3>
                <small class="text-muted">{{ $stats['porc_aprobados'] ?? 0 }}%</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">PMIs Presentados</span>
                <h3 class="card-title mb-2">{{ $stats['pmi_presentados'] ?? 0 }}</h3>
                <small class="text-muted">{{ $stats['porc_presentados'] ?? 0 }}%</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">Autoev. en Proceso</span>
                <h3 class="card-title mb-2">{{ $stats['autoevaluaciones_proceso'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 d-flex">
        <div class="card kpi-card h-100 w-100">
            <div class="card-body">
                <span class="d-block mb-1">Autoev. en Validación</span>
                <h3 class="card-title mb-2">{{ $stats['autoevaluaciones_validacion'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Fila 1 de gráficos -->
    <div class="col-12 col-xl-6 d-flex">
        <div class="card chart-card h-100 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Distribución de PMI por estado</h5>
            </div>
            <div class="card-body">
                <div id="chart-pmi-estado"></div>
            </div>
        </div>
    </div>

    <!-- Fila 2 de gráficos -->
    <div class="col-12 col-xl-6 d-flex">
        <div class="card chart-card h-100 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Autoevaluaciones por estado</h5>
            </div>
            <div class="card-body">
                <div id="chart-autoevaluaciones-estado"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-12 d-flex">
        <div class="card chart-card h-100 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Top municipios por instituciones</h5>
            </div>
            <div class="card-body">
                <div id="chart-instituciones-municipio"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendors_css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('custom_css')
<style>
  .kpi-card { min-height: 140px; }
  .kpi-card .card-body { display: flex; flex-direction: column; justify-content: center; }
  .chart-card { min-height: 420px; }
  #chart-pmi-estado, #chart-instituciones-municipio, #chart-autoevaluaciones-estado, #chart-sedes-municipio { min-height: 320px; }
</style>
@endsection

@section('vendors_js')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('javascripts')
<script>
    (function() {
        const chartDataPmi = @json($charts['pmi_por_estado'] ?? ['labels'=>[],'series'=>[]]);
        const chartDataMun = @json($charts['instituciones_por_municipio'] ?? ['labels'=>[],'series'=>[]]);
        const chartDataAuto = @json($charts['autoevaluaciones_por_estado'] ?? ['labels'=>[],'series'=>[]]);
        const chartDataSedes = @json($charts['sedes_por_municipio'] ?? ['labels'=>[],'series'=>[]]);

        // Donut PMI por estado
        const pmiEstadoOptions = {
            series: chartDataPmi.series || [],
            labels: chartDataPmi.labels || [],
            chart: { type: 'donut', height: 320 },
            legend: { position: 'bottom' },
            dataLabels: { enabled: true },
        };
        const pmiEstadoChart = new ApexCharts(document.querySelector('#chart-pmi-estado'), pmiEstadoOptions);
        pmiEstadoChart.render();

        // Barras instituciones por municipio
        const instMunOptions = {
            series: [{
                name: 'Instituciones',
                data: chartDataMun.series || []
            }],
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            xaxis: { categories: chartDataMun.labels || [] },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            dataLabels: { enabled: false },
        };
        const instMunChart = new ApexCharts(document.querySelector('#chart-instituciones-municipio'), instMunOptions);
        instMunChart.render();

        // Autoevaluaciones por estado (donut)
        const autoEstadoOptions = {
            series: chartDataAuto.series || [],
            labels: chartDataAuto.labels || [],
            chart: { type: 'donut', height: 320 },
            legend: { position: 'bottom' },
            dataLabels: { enabled: true },
        };
        const autoEstadoChart = new ApexCharts(document.querySelector('#chart-autoevaluaciones-estado'), autoEstadoOptions);
        autoEstadoChart.render();

        // Sedes por municipio (barras)
        const sedesMunOptions = {
            series: [{ name: 'Sedes', data: chartDataSedes.series || [] }],
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            xaxis: { categories: chartDataSedes.labels || [] },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            dataLabels: { enabled: false },
        };
        const sedesMunChart = new ApexCharts(document.querySelector('#chart-sedes-municipio'), sedesMunOptions);
        sedesMunChart.render();
    })();
</script>
@endsection

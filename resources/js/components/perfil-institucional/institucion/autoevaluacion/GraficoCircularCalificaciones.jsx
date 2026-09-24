import { useEffect, useRef } from 'react';
import { Chart } from 'chart.js/auto';

export default function GraficoCircularCalificaciones({ statistics = [] }) {
    const chartRefs = useRef([]);

    const categoryColors = {
        'Existencia': 'rgba(220, 53, 69, 0.7)',
        'Pertinencia': 'rgba(255, 193, 7, 0.7)',
        'Apropiación': 'rgba(23, 162, 184, 0.7)',
        'Mejoramiento': 'rgba(40, 167, 69, 0.7)'
    };

    const calcularTotalArea = (area) => {
        return (
            (area.ponderados.Existencia || 0) +
            (area.ponderados.Pertinencia || 0) +
            (area.ponderados.Apropiación || 0) +
            (area.ponderados.Mejoramiento || 0)
        );
    };

    const calcularPorcentaje = (valor, total) => {
        if (total === 0) return 0;
        return parseFloat(((valor / total) * 100).toFixed(2));
    };

    useEffect(() => {
        // Evitar gráficos duplicados
        chartRefs.current.forEach((ref, index) => {
            if (!ref || !ref.getContext || !statistics[index]) return;

            const area = statistics[index];
            const total = calcularTotalArea(area);

            const datos = [
                { label: 'Existencia', value: area.ponderados.Existencia || 0 },
                { label: 'Pertinencia', value: area.ponderados.Pertinencia || 0 },
                { label: 'Apropiación', value: area.ponderados.Apropiación || 0 },
                { label: 'Mejoramiento', value: area.ponderados.Mejoramiento || 0 }
            ].map(d => ({
                ...d,
                porcentaje: calcularPorcentaje(d.value, total)
            }));

            new Chart(ref.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: datos.map(d => `${d.label}: ${d.porcentaje}%`),
                    datasets: [{
                        data: datos.map(d => d.value),
                        backgroundColor: datos.map(d => categoryColors[d.label]),
                        borderColor: datos.map(d => categoryColors[d.label].replace('0.7', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' },
                        title: {
                            display: true,
                            text: `Distribución de Calificaciones - ${area.nombre}`
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const { label, raw } = context;
                                    return `${label}: ${raw}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    }, [statistics]);

    if (!statistics.length) {
        return <div className="alert alert-info">No hay datos estadísticos disponibles</div>;
    }

    return (
        <div className="container mt-4">
            {statistics.map((stat, idx) => (
                <div key={idx} className="card mb-4">
                    <div className="card-body">
                        <div style={{ height: '400px' }}>
                            <canvas ref={el => chartRefs.current[idx] = el}></canvas>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}

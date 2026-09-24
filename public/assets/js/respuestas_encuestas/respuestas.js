function mostrarEstadisticas(encuestaId) {
    // Llamada a la API para obtener los datos de estadísticas
    fetch(`/api/estadisticaEncuestasWeb/${encuestaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar los datos de la encuesta.');
            }
            return response.json();
        })
        .then(data => {
            // Título de la encuesta
            const modalTitle = document.getElementById('modalTitle');
            modalTitle.textContent = data.titulo;

            // Fecha de creación
            const modalFecha = document.getElementById('modalFecha');
            modalFecha.textContent = `Fecha de creación: ${data.fecha_creacion}`;

            // Configuración de datos para el gráfico
            const chartLabels = data.respuestas.map(item => item.respuesta);
            const chartData = data.respuestas.map(item => item.total_respuestas);
            const chartColors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
            ];

            // Actualización del gráfico
            const ctx = document.getElementById('pieChart').getContext('2d');
            if (window.myChart) {
                window.myChart.destroy(); // Eliminar gráfico existente
            }
            window.myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: chartData,
                        backgroundColor: chartColors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value} respuestas`;
                                }
                            }
                        }
                    }
                }
            });

            // Mostrar los totales de respuestas debajo del gráfico
            const totalesContainer = document.getElementById('totalesRespuestas');
            totalesContainer.innerHTML = ''; // Limpiar el contenedor de respuestas previas
            data.respuestas.forEach((item, index) => {
                const respuestaElement = document.createElement('p');
                
                // Crear un contenedor para la viñeta y el texto
                const respuestaRow = document.createElement('div');
                respuestaRow.classList.add('d-flex', 'align-items-center');
                
                // Crear la viñeta (círculo)
                const viñeta = document.createElement('span');
                viñeta.style.width = '15px';
                viñeta.style.height = '15px';
                viñeta.style.borderRadius = '50%';
                viñeta.style.backgroundColor = chartColors[index]; // Asignar color correspondiente
                viñeta.style.marginRight = '10px';
                
                // Añadir la viñeta y el texto
                respuestaRow.appendChild(viñeta);
                respuestaElement.textContent = `${item.respuesta}: ${item.total_respuestas} respuestas`;
                respuestaRow.appendChild(respuestaElement);
                
                // Añadir al contenedor
                totalesContainer.appendChild(respuestaRow);
            });

            // Mostrar la modal
            $('#modalEstadisticas').modal('show');
        })
        .catch(error => {
            console.error('Error al mostrar las estadísticas:', error);
            alert('No se pudieron cargar las estadísticas de la encuesta.');
        });
}

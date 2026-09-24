$(document).ready(function() {
    // Al cambiar el conjunto
    // $('#conjunto_id').change(function() {
    //     var conjunto_id = $(this).val();

    //     if (conjunto_id) {
    //         $.ajax({
    //             url: '/get-bloques/' + conjunto_id,
    //             type: 'GET',
    //             success: function(data) {
    //                 $('#bloque_id').empty().append('<option value="">-- Seleccione --</option>');
    //                 $.each(data, function(key, value) {
    //                     $('#bloque_id').append('<option value="' + value.id + '">' + value.nombre + '</option>');
    //                 });
    //             }
    //         });
    //     } else {
    //         $('#bloque_id').empty().append('<option value="">-- Seleccione --</option>');
    //         $('#apartamento_id').empty().append('<option value="">-- Seleccione --</option>');
    //     }
    // });

    // Al cambiar el bloque
    $('#bloque_id').change(function() {
        var bloque_id = $(this).val();

        if (bloque_id) {
            $.ajax({
                url: '/get-apartamentos/' + bloque_id,
                type: 'GET',
                success: function(data) {
                    $('#apartamento_id').empty().append('<option value="">-- Seleccione --</option>');
                    $.each(data, function(key, value) {
                        $('#apartamento_id').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                }
            });
        } else {
            $('#apartamento_id').empty().append('<option value="">-- Seleccione --</option>');
        }
    });

    $('#filter_bloque_id').change(function() {
        var filter_bloque_id = $(this).val();

        if (filter_bloque_id) {
            $.ajax({
                url: '/get-apartamentos/' + filter_bloque_id,
                type: 'GET',
                success: function(data) {
                    $('#filter_apartamento_id').empty().append('<option value="">-- Seleccione --</option>');
                    $.each(data, function(key, value) {
                        $('#filter_apartamento_id').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                }
            });
        } else {
            $('#filter_apartamento_id').empty().append('<option value="">-- Seleccione --</option>');
        }
    });

    $(document).ready(function() {
        // Inicializar el DataTable con filtros personalizados
        var table = $('#dt-search-residente').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/searchResidenteJson',
                data: function (d) {
                    // Pasar los valores de los filtros al backend
                    d.filter_usuario_id = $('#filter_usuario_id').val();
                    d.filter_bloque_id = $('#filter_bloque_id').val();
                    d.filter_apartamento_id = $('#filter_apartamento_id').val();
                    d.filter_estado = $('#filter_estado').val();
                    d.filter_tipo_residente = $('#filter_tipo_residente').val();
                }
            },
            columns: [
                { data: 'bloque', name: 'bloque_id' },
                { data: 'apartamento', name: 'apartamento_id' },
                { data: 'usuario', name: 'usuario' },
                { data: 'estado', name: 'estado' },
                { data: 'tipo_residente', name: 'tipo_residente' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Evento para aplicar filtros
        $('#filter').on('click', function() {
            table.draw();  // Volver a cargar la tabla con los nuevos filtros
        });

        // Evento para resetear filtros
        $('#reset').on('click', function() {
            $('#filter_bloque_id').val('');  // Limpiar el campo de nombre
            $('#filter_apartamento_id').val('');  // Limpiar el campo de nombre
            $('#filter_usuario_id').val('');  // Limpiar el campo de nombre
            $('#filter_estado').val('');  // Limpiar el campo de nombre
            $('#filter_tipo_residente').val('');  // Limpiar el campo de nombre
            table.draw();  // Volver a cargar la tabla sin filtros
        });
    });

});

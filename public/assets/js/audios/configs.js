

var editModal = $('#modalUpdateConfig');

function validateFields(){
    var idConfiguracion         = document.getElementById('idConfiguracion');
    var tamanio_audio_edit      = document.getElementById('tamanio_audio_edit');
    var extension_audio_edit    = document.getElementById('extension_audio_edit');
    var extension_documento_edit = document.getElementById('extension_documento_edit');
    var tamanio_documento_edit  = document.getElementById('tamanio_documento_edit');

    if( idConfiguracion.value == "" || extension_documento_edit.value == "" || extension_audio_edit.value == "" || tamanio_audio_edit.value == "" || tamanio_documento_edit.value == "" ){
        return false;
    }else{
        return true;
    }
}

$(document).on("click", "#btn_update_config", function(e) {
    if (e.type == "submit") {
        e.preventDefault();
    }

    var id                      = document.getElementById('idConfiguracion').value;
    var tamanio_audio_edit      = document.getElementById('tamanio_audio_edit').value;
    var extension_audio_edit    = document.getElementById('extension_audio_edit').value;
    var extension_documento_edit = document.getElementById('extension_documento_edit').value;
    var tamanio_documento_edit  = document.getElementById('tamanio_documento_edit').value;

    data       = new FormData();
    data.append('id', id);
    data.append('tamanio_audio', tamanio_audio_edit);
    data.append('extension_audio', extension_audio_edit);
    data.append('extension_documento', extension_documento_edit);
    data.append('tamanio_documento', tamanio_documento_edit);

    var error = validateFields();

    if( error )
    {
        $.ajax({
            url: '/update_config',
            type: 'POST',
            contentType:false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(data) {
                if (data.status) {
                    document.getElementById('idConfiguracion').value = '';
                    setTimeout(function(){ $('#modalUpdateConfig').modal('hide'); }, 1000);
                    alert(data.msj);
                    location.reload();
                }else{
                    alert("No se ha podido cargar la información.");
                    setTimeout(function(){ $('#modalUpdateConfig').modal('hide'); }, 1000);
                    alert(data.msj);
                    location.reload();
                }
            }
        });
    }else{
        alert('Hace falta informacion');
    }
    return false;

});

function getDataConfig(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get_info_config',
        type: 'GET',
        dataType: 'json',
        data: {id: id},
        success: function(data) {
            if (data.status) {
                document.getElementById('idConfiguracion').value = data.config.id;
                document.getElementById('tamanio_audio_edit').value = data.config.tamanio_audio;
                document.getElementById('extension_audio_edit').value = data.config.extension_audio;
                document.getElementById('extension_documento_edit').value = data.config.extension_documento;
                document.getElementById('tamanio_documento_edit').value = data.config.tamanio_documento;
            }else{
                alert("No se ha podido cargar la información.");
            }
        }
    });
}


function openModalConfig(id_config){
    editModal.modal("show");
    getDataConfig(id_config);
}
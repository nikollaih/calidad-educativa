

var editModal = $('#modalUpdateAudio');


function actualizarArchivoAudio(input){
    var files   = input.files[0];
    var id      = document.getElementById('idArchivoAudio').value;

    data       = new FormData();
    data.append('files', files);
    data.append('id', id);

    if( files != null && id != '')
    {
        $.ajax({
            url: '/update_audio_json',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function(data) {
                if (data.status) {
                    document.getElementById('idArchivoAudio').value = '';
                    setTimeout(function(){ $('#modalUpdateAudio').modal('hide'); }, 1000);
                    location.reload();
                }else{
                    alert("No se ha podido cargar la información.");
                    setTimeout(function(){ $('#modalUpdateAudio').modal('hide'); }, 1000);
                    location.reload();
                }
            }
        });
    }
}

function getDataFile(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get_info_archivo',
        type: 'GET',
        dataType: 'json',
        data: {id: id},
        success: function(data) {
            if (data.status) {
                if(document.getElementById('idArchivoAudio')){
                    document.getElementById('idArchivoAudio').value = data.archivo.id;
                }
                if(document.getElementById('idArchivo')){
                    document.getElementById('idArchivo').value = data.archivo.id;
                }
            }else{
                alert("No se ha podido cargar la información.");
            }
        }
    });
}


function openModalArchivoAudio(id_audio){
    editModal.modal("show");
    getDataFile(id_audio);
}
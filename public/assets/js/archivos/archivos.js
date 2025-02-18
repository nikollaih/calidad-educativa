var editModal = $('#modalUpdateFile');


function actualizarArchivo(input){
    var files   = input.files[0];
    var id      = document.getElementById('idArchivo').value;

    data       = new FormData();
    data.append('files', files);
    data.append('id', id);

    if( files != null && id != '')
    {
        $.ajax({
            url: '/update_file_json',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function(data) {
                if (data.status) {
                    document.getElementById('idArchivo').value = '';
                    setTimeout(function(){ $('#modalUpdateFile').modal('hide'); }, 1000);
                    location.reload();
                }else{
                    alert("No se ha podido cargar la información.");
                    setTimeout(function(){ $('#modalUpdateFile').modal('hide'); }, 1000);
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


function openModalArchivo(id_audio){
    editModal.modal("show");
    getDataFile(id_audio);
}

function deleteFile(id_file){
    // console.log(id_file);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if( id_file )
    {
        let data       = new FormData();
        data.append('id', id_file);

        $.ajax({
            url: '/deleteFile_json',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            async : false,
            success: function(data) {
                if (data.status) {
                    alert("Archivo Eliminado.");
                    location.reload();
                }else{
                    alert("Archivo No Eliminado.");
                    location.reload();
                }
            }
        });
    }
}

function editFile(id_file){
    window.location.href = "files_edit/"+id_file;
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// confirmAgua = document.querySelector('#reiniciarAgua');

function sumarElemento( id, servicio){
    
    data       = new FormData();
    data.append('id', id);
    data.append('elemento', servicio);

    $.ajax({
        url: '/sumarElemento',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: data,
        success: function(data) {
            if (data.status) {
                console.log('Success');
                setTimeout(() => {
                    location.reload()
                  }, 1000);
            }else{
                alert("No se ha podido almacenar la información.");
            }
        }
    });
}

function restarElemento( id, servicio){
    
    data       = new FormData();
    data.append('id', id);
    data.append('elemento', servicio);

    $.ajax({
        url: '/restarElemento',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: data,
        success: function(data) {
            if (data.status) {
                console.log('Success');
                setTimeout(() => {
                    location.reload()
                }, 1000);
            }else{
                alert("No se ha podido almacenar la información.");
            }
        }
    });
}

function reiniciarElemento( id ){
    
    data       = new FormData();
    data.append('id', id);
    
    $.ajax({
        url: '/reiniciarCorrespondencia',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: data,
        success: function(data) {
            if (data.status) {
                alert(data.message);
                setTimeout(() => {
                    location.reload()
                }, 1000);
            }else{
                alert(data.message);
            }
        }
    });
}

// if (confirmAgua) {
//     confirmAgua.onclick = function () {
//       Swal.fire({
//         title: 'escriba el servicio que desea reiniciar',
//         input: 'text',
//         inputAttributes: {
//           autocapitalize: 'on'
//         },
//         showCancelButton: true,
//         confirmButtonText: 'Reiniciar',
//         showLoaderOnConfirm: true,
//         customClass: {
//           confirmButton: 'btn btn-primary me-3',
//           cancelButton: 'btn btn-label-danger'
//         },
//         preConfirm: servicio => {
//           return fetch('/reiniciarServicio/' + servicio)
//             .then(response => {
//               if (!response.ok) {
//                 throw new Error(response.statusText);
//               }
//               return response.json();
//             })
//             .catch(error => {
//               Swal.showValidationMessage('Request failed:' + error);
//             });
//         },
//         backdrop: true,
//         allowOutsideClick: () => !Swal.isLoading()
//       }).then(result => {
//         if (result.isConfirmed) {
//           Swal.fire({
//             title: result.value.login + "'s avatar",
//             imageUrl: result.value.avatar_url,
//             customClass: {
//               confirmButtonText: 'Close me!',
//               confirmButton: 'btn btn-primary'
//             }
//           });
//         }
//       });
//     };
//   }
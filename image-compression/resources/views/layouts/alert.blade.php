<!--- TOAST --->
<script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>

<!--- SWEET ALERT --->
<script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

<!--- JQUERY --->
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

<script>

    @if(session('success'))
        displayAlert('{{ session('success') }}','#4fbe87')
    @endif

    @if(session('error'))
        displayAlert('{{ session('error') }}','#eb311c')
    @endif

    @if(session('errors'))
        displayAlert('{{ session('error') }}','#eb311c')
    @endif

    function displayAlert($message, $bakgroundColor){
            Toastify({
                text: $message,
                duration: 4000,
                close:true,
                gravity:"top",
                position: "right",
                backgroundColor: $bakgroundColor,
            }).showToast();
    }

    function alertConfirmationDelete(title,message,url){
        Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type    : 'DELETE',
                    url     : url,
                    success : (response) => {
                        displayAlert(response.message,'#4fbe87')
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        displayAlert(error.responseJSON.message,'#eb311c')
                    }
                });
            }
        })
    }

    function alertConfirmation(title,message,url){
        Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type    : 'GET',
                    url     : url,
                    success : (response) => {
                        displayAlert(response.message,'#4fbe87')
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        displayAlert(error.responseJSON.message,'#eb311c')
                    }
                });
            }
        })
    }

</script>


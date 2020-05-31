<script>
    $(document).ready(function() {
        $('.btn-exit-system').on('click', function(e) {
            e.preventDefault();
            var token = $(this).attr('href');
            swal({
                title: 'Estás seguro?',
                text: "La sesion actual se cerrará y deberas iniciar sesion nuevamente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#03A9F4',
                cancelButtonColor: '#F44336',
                confirmButtonText: '<i class="zmdi zmdi-run"></i> Si, Cerrar!',
                cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> No, Cancelar!'
            }).then(function() {


                $.ajax({
                    url: '<?php echo SERVERURL; ?>ajax/LoginAjax.php?token=' + token,


                    success: function(data) {
                        if (data == "true") {
                            window.location.href = "<?php echo SERVERURL; ?>login/";
                        } else {
                            swal(
                                "Ocurrio un error",
                                "No se pudo cerrar la sesion",
                                "error"
                            );
                        }
                    }
                });
            });
        });
    });
</script>
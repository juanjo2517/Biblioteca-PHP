<?php
$peticionAjax = true;
require_once "../core/config-general.php";

if(isset($_GET['token'])){
    require_once "../controllers/LoginController.php";
    $logout = new LoginController();
    echo $logout->cerrar_session_controller();
}else{
    session_start();
    session_destroy();
    echo '<script>window.location.href="'.SERVERURL.'login/"</script>';
}
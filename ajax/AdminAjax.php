<?php
$peticionAjax = true;
require_once "../core/config-general.php";
if(isset($_POST['dni']) || isset($_POST['codigo-delete'])){
   require_once "../controllers/AdminController.php";

   $adminObj = new AdminController();

   if(isset($_POST['dni']) && isset($_POST['nombre']) 
   && isset($_POST['apellido']) && isset($_POST['usuario'])){

    echo $adminObj->agregar_adminCotroller();

   }

   if(isset($_POST['codigo-delete']) && isset($_POST['privilegio-admin'])){
       
        echo $adminObj->eliminar_admin_controller();
   }

}else{
    session_start();
    session_destroy();
    echo '<script>window.location.href="'.SERVERURL.'login/"</script>';
}
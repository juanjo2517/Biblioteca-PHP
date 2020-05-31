<?php

require './models/ViewsModel.php';

class ViewsController extends ViewsModel
{
 

    public function obtener_plantilla_controller()
    {

        return require_once './views/plantilla.php';
    }

    public function obtener_vistas_controller()
    {
        if (isset($_GET['views'])) {
            $ruta = explode("/", $_GET['views']);
            $respuesta = ViewsModel::obtener_vistas_model($ruta[0]);
        } else {

            $respuesta = "login";
        }
        return $respuesta;
    }

    
}

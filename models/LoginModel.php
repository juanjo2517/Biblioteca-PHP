<?php

if ($peticionAjax) {
    require_once "../core/MainModel.php";
} else {
    require_once "./core/MainModel.php";
}

class LoginModel extends MainModel
{

    protected function inicio_Model($datos)
    {

        $sql = MainModel::conexion()->prepare("SELECT * FROM cuenta 
        WHERE CuentaUsuario=:usuario AND CuentaClave=:clave ");

        $sql->bindParam(":usuario", $datos['usuario']);
        $sql->bindParam(":clave", $datos['clave']);

        $sql->execute();

        return $sql;
    }

    protected function cerrar_session_model($datos){

        if ($datos['usuario'] != "" && $datos['token_BP'] == $datos['token']) {

            $updateBit = MainModel::actualizar_bitacora($datos['codigo'],$datos['hora']);

            if($updateBit->rowCount()==1){
                session_unset();
                session_destroy();
                $respuesta = "true";
            }else{
                $respuesta = "false";
            }
        } else {
            $respuesta = "false";
        }

        return $respuesta;
    }
}

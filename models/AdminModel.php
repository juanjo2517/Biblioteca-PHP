<?php

if ($peticionAjax) {
    require_once "../core/MainModel.php";
} else {
    require_once "./core/MainModel.php";
}


class AdminModel extends MainModel
{

    protected function agregar_adminModel($datos)
    {

        $sql = MainModel::conexion()->prepare("INSERT INTO admin (AdminDNI, AdminNombre, AdminApellido, 
        AdminTelefono, AdminDireccion, CuentaCodigo) 
        VALUES (:dni, :nombre, :apellido, :telefono, :direccion, :codigo)");
        $sql->bindParam(':dni', $datos['dni']);
        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);
        $sql->bindParam(":telefono", $datos['telefono']);
        $sql->bindParam(":direccion", $datos['direccion']);
        $sql->bindParam(":codigo", $datos['codigo']);
        $sql->execute();

        return $sql;
    }

    protected function eliminar_admin_model($codigo){

        $query = MainModel::conexion()->prepare("DELETE FROM admin 
        WHERE CuentaCodigo=:codigo" );

        $query->bindParam(":codigo",$codigo); 

        $query->execute();

        return $query; 

    }


}

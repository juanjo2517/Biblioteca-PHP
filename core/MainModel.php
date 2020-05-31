<?php

if ($peticionAjax) {
    require_once "../core/configAPP.php";
} else {
    require_once "./core/configAPP.php";
}



class MainModel
{

    protected function conexion()
    {
        try {

            $conexion = new PDO(SGDB, USER, PASSWORD);
            return $conexion;
        } catch (PDOException $e) {

            echo "ERROR " . $e->getMessage();
        }
    }

    protected function ejecutar_consulta_simple($query)
    {

        $respuesta = self::conexion()->prepare($query);

        $respuesta->execute();

        return $respuesta;
    }

    protected function agregar_cuenta($datos)
    {
        $sql = self::conexion()->prepare("INSERT INTO cuenta (CuentaCodigo, CuentaPrivilegio, 
        CuentaUsuario, CuentaClave, CuentaEmail, CuentaEstado, CuentaTipo, 
        CuentaGenero, CuentaFoto)  
        VALUES (:codigo,:privilegio, :usuario, :clave, :email, :estado, 
        :tipo, :genero, :foto)");
        $sql->bindParam(':codigo', $datos['codigo']);
        $sql->bindParam(':privilegio', $datos['privilegio']);
        $sql->bindParam(':usuario', $datos['usuario']);
        $sql->bindParam(':clave', $datos['clave']);
        $sql->bindParam(':email', $datos['email']);
        $sql->bindParam(':estado', $datos['estado']);
        $sql->bindParam(':tipo', $datos['tipo']);
        $sql->bindParam(':genero', $datos['genero']);
        $sql->bindParam(':foto', $datos['foto']);
        $sql->execute();

        return $sql; 
    }
    
    protected function eliminar_cuenta($codigo){
        $sql = self::conexion()->prepare("DELETE FROM cuenta 
        WHERE CuentaCodigo = :codigo"); 
        $sql->bindParam(":codigo",$codigo);
        $sql->execute(); 

        return $sql; 
    }

    protected function guardar_bitacora($datos){

    
        $sql = self::conexion()->prepare("INSERT INTO bitacora (BitacoraCodigo,
        BitacoraFecha, BitacoraHoraInicio, BitacoraHoraFinal, BitacoraTipo, 
        BitacoraYear, CuentaCodigo) VALUES (:codigo, :fecha, :horaIncio, :horaFinal,
        :tipo, :year, :CuentaCodigo)"); 

        $sql->bindParam(":codigo",$datos['codigo']);
        $sql->bindParam(":fecha",$datos['fecha']);
        $sql->bindParam(":horaIncio",$datos['horaInicio']);
        $sql->bindParam(":horaFinal",$datos['horaFinal']);
        $sql->bindParam(":tipo",$datos['tipo']);
        $sql->bindParam(":year",$datos['year']);
        $sql->bindParam(":CuentaCodigo",$datos['CuentaCodigo']);


        $sql->execute();

        return $sql; 


    }

    protected function actualizar_bitacora($codigo, $hora){

        $sql = self::conexion()->prepare("UPDATE bitacora 
        SET BitacoraHoraFinal=:hora WHERE BitacoraCodigo=:codigo");
        
        $sql->bindParam(":hora",$hora);
        $sql->bindParam(":codigo",$codigo);

        $sql->execute();

        return $sql;
    }

    protected function eliminar_bitacora($codigo){

        $sql = self::conexion()->prepare("DELETE FROM bitacora 
        WHERE CuentaCodigo=:codigo");

        $sql->bindParam(":codigo",$codigo); 

        $sql->execute(); 

        return $sql; 
    }

    public function encryption($string)
    {

        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    protected function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    protected function generar_codigo_aleatorio($letra, $longitud, $num)
    {

        for ($i = 1; $i <= $longitud; $i++) {

            $numero = rand(0, 9);
            $letra .= $numero;
        }

        return $letra . $num;
    }

    protected function limpiar_cadena($cadena)
    {

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script type=>", "", $cadena);
        $cadena = str_ireplace("<script src>", "", $cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("<?php>", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("SELECT *FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        

        return $cadena;
    }
    protected function sweet_alert($datos)
    {

        if ($datos['alerta'] == "simple") {

            $alert = "
                    <script>
                    
                    swal(
                        '".$datos['titulo']."',
                        '" . $datos['texto'] . "',
                        '" . $datos['tipo'] . "'
                      )
                    </script>
            ";
        } elseif ($datos['alerta'] == "recargar") {
            $alert = "
                    <script>
                    
                    swal({
                        title: '" . $datos['titulo'] . "',
                        text: '" . $datos['texto'] . "',
                        type: '" . $datos['tipo'] . "',

                        confirmButtonText: 'Aceptar'
                      }).then(function()  {
                       
                        location.reload(); 
                        
                        
                      });
                    </script>
            ";
        } elseif ($datos['alerta'] == 'limpiar') {
            $alert = "
            <script>
            
            swal({
                title: '" . $datos['titulo'] . "',
                text: '" . $datos['texto'] . "',
                type: '" . $datos['tipo'] . "',

                confirmButtonText: 'Aceptar'
              }).then(function() {
               
                $('.FormularioAjax')[0].reset(); 
              });
            </script>
    ";
        }
        return $alert;
    }
}

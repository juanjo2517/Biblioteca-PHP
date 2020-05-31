<?php

if ($peticionAjax) {
    require_once "../models/LoginModel.php";
} else {
    require_once "./models/LoginModel.php";
}

class LoginController extends LoginModel
{

    public function inicio_controller()
    {

        $usuario = MainModel::limpiar_cadena($_POST['usuario']);
        $clave = MainModel::limpiar_cadena($_POST['clave']);

        $clave = MainModel::encryption($clave);

        $datosLogin = [
            "usuario" => $usuario,
            "clave" => $clave
        ];

        $datosCuenta = LoginModel::inicio_model($datosLogin);
 

        if ($datosCuenta->rowCount() == 1) {
            
            

            $row = $datosCuenta->fetch();
            

            $fechaActual = date("Y-m-d");
            $añoActual = date("Y");
            $horaActual = date("h:i:s a");

            $consulta1 = MainModel::ejecutar_consulta_simple("SELECT id 
            FROM bitacora");

            $numero = ($consulta1->rowCount()) + 1;
            

            $codigoBit = MainModel::generar_codigo_aleatorio("BT", 7, $numero);

            $datosBit = [
                "codigo" => $codigoBit,
                "fecha" => $fechaActual,
                "horaInicio" => $horaActual,
                "horaFinal" => "Sin registro",
                "tipo" => $row['CuentaTipo'],
                "year" => $añoActual,
                "CuentaCodigo" => $row['CuentaCodigo']

            ];

            if($row['CuentaEstado'] == "Bloqueado"){
                $alerta = [
                    "alerta" => "simple",
                    "titulo" => "Error Inesperado",
                    "texto" => "¡TU CUENTA ESTÁ BLOQUEADA!",
                    "tipo" => "error"
                ];
                return MainModel::sweet_alert($alerta);

            }else
            

            
            

            $saveBit = MainModel::guardar_bitacora($datosBit);

           echo $saveBit->rowCount();
       
            
             
            if ($saveBit->rowCount() >= 1) {
               
                session_start(["name" => 'BP']);
                $_SESSION['usuario_BP'] = $row['CuentaUsuario'];
                $_SESSION['tipo_BP'] = $row['CuentaTipo'];
                $_SESSION['privilegio_BP'] = $row['CuentaPrivilegio'];
                $_SESSION['foto_BP'] = $row['CuentaFoto'];
                $_SESSION['token_BP'] = md5(uniqid(mt_rand(), true));
                $_SESSION['codigoCuenta_BP'] = $row['CuentaCodigo'];
                $_SESSION['codigoBit_BP'] = $codigoBit;
                $_SESSION['estado'] = $row['CuentaEstado'];
                $codigoAdmin = $_SESSION['codigoCuenta_BP'];

                $query = MainModel::ejecutar_consulta_simple("SELECT * FROM admin
                WHERE CuentaCodigo='$codigoAdmin'");

                if(!$query->rowCount()==1){
                    $alerta = [
                        "alerta" => "simple",
                        "titulo" => "Error Inesperado",
                        "texto" => "Error a la hora de cargar los datos",
                        "tipo" => "error"
                    ];
                }else 

                $admin = $query->fetch(); 
                $_SESSION['nombre'] = $admin['AdminNombre'];
                $_SESSION['apellido'] = $admin['AdminApellido']; 

                

                if ($row['CuentaTipo']=="Administrador") {
                    
                    $url = SERVERURL."home/";
                } else {
                    $url = SERVERURL."catalog/";
                }
             $urlLocation = '<script>window.location="'.$url.'"</script>';
             return $urlLocation;
                  

            } else {
                $alerta = [
                    "alerta" => "simple",
                    "titulo" => "Error Inesperado",
                    "texto" => "No se ha podido Iniciar Sesión por problemas técnicos. Por favor intente de nuevo",
                    "tipo" => "error"
                ];
            }
        } else {

            $alerta = [
                "alerta" => "simple",
                "titulo" => "Error Inesperado",
                "texto" => "Datos de Acceso Incorrectos",
                "tipo" => "error"
            ];

            return MainModel::sweet_alert($alerta);
        }
    
    }

    public function cerrar_session_controller(){
        session_start(["name" => 'BP']);
        $token = MainModel::decryption($_GET['token']);
        $hora = date("h:i:s a");
        $datosCerrar = [
            "usuario" => $_SESSION['usuario_BP'],
            "token_BP" => $_SESSION['token_BP'],
            "token" => $token,
            "codigo" => $_SESSION['codigoBit_BP'],
            "hora" => $hora
        ];

        return LoginModel::cerrar_session_model($datosCerrar);

    }

    public function forzar_cierre_sesion_controller(){
        session_destroy();
        return header("Location: ".SERVERURL."login/");
    }
}

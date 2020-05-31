<?php

if ($peticionAjax) {
    require_once "../models/AdminModel.php";
} else {
    require_once "./models/AdminModel.php";
}



class AdminController extends AdminModel
{

    //Controller Agregar Admin

    public function agregar_adminCotroller()
    {

        $mainObj = new MainModel();
        //Datos personales

        $dni = MainModel::limpiar_cadena($_POST['dni']);
        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
        $apellido = MainModel::limpiar_cadena($_POST['apellido']);
        $telefono = MainModel::limpiar_cadena($_POST['telefono']);
        $direccion = MainModel::limpiar_cadena($_POST['direccion']);


        //Datos de la cuenta 
        $usuario = MainModel::limpiar_cadena($_POST['usuario']);
        $password1 = MainModel::limpiar_cadena($_POST['password1']);
        $password2 = MainModel::limpiar_cadena($_POST['password2']);
        $email = MainModel::limpiar_cadena($_POST['email']);
        $genero = MainModel::limpiar_cadena($_POST['optionsGenero']);
        $privilegio = MainModel::decryption($_POST['optionsPrivilegio']);
        $privilegio = MainModel::limpiar_cadena($privilegio);





        if ($genero == "Masculino") {

            $foto = "masculino.png";
        } else {

            $foto = "femenino.png";
        }
        if($privilegio<1 || $privilegio>3){
            $alerta = [
                "alerta" => "simple",
                "titulo" => "Error Inesperado",
                "texto" => "Nivel de privilegio invalido",
                "tipo" => "error"
            ];
        }else{

        if ($password1 != $password2) {
            $alerta = [
                "alerta" => "simple",
                "titulo" => "Error Inesperado",
                "texto" => "Las contraseñas no coinciden. Intenta de nuevo",
                "tipo" => "error"
            ];
        } else {


            $consulta1 = MainModel::ejecutar_consulta_simple("SELECT * FROM admin 
        WHERE AdminDNI='$dni'");

            if ($consulta1->rowCount() >= 1) {
                $alerta = [
                    "alerta" => "simple",
                    "titulo" => "Error Inesperado",
                    "texto" => "La cédula ingresada ya está registrada",
                    "tipo" => "error"
                ];
            } else {


                if ($email != "") {

                    $consulta2 = MainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta 
                     WHERE CuentaEmail='$email'");

                    $emailCuenta = $consulta2->rowCount();
                } else {

                    $emailCuenta = 0;
                }
                if ($emailCuenta >= 1) {
                    $alerta = [
                        "alerta" => "simple",
                        "titulo" => "Error Inesperado",
                        "texto" => "El Email ingresado ya está registrado",
                        "tipo" => "error"
                    ];
                } else {

                    $consulta3 = MainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta 
                    WHERE CuentaUsuario='$usuario'");
                    if ($consulta3->rowCount() >= 1) {
                        $alerta = [
                            "alerta" => "simple",
                            "titulo" => "Error Inesperado",
                            "texto" => "El Usuario Ingresado ya está registrado",
                            "tipo" => "error"
                        ];
                    } else {

                        $consulta4 = MainModel::ejecutar_consulta_simple("SELECT id 
                        FROM cuenta ");
                        $numero = ($consulta4->rowCount()) + 1;


                        $codigo = MainModel::generar_codigo_aleatorio("AC", 7, $numero);


                        $clave = MainModel::encryption($password1);


                        $dataCuenta = [
                            "codigo" => $codigo,
                            "privilegio" => $privilegio,
                            "usuario" => $usuario,
                            "clave" => $clave,
                            "email" => $email,
                            "estado" => "Activo",
                            "tipo" => "Administrador",
                            "genero" => $genero,
                            "foto" => $foto
                        ];



                        $saveCuenta = MainModel::agregar_cuenta($dataCuenta);

                        if ($saveCuenta->rowCount() >= 1) {

                            $dataAdmin = [
                                "dni" => $dni,
                                "nombre" => $nombre,
                                "apellido" => $apellido,
                                "telefono" => $telefono,
                                "direccion" => $direccion,
                                "codigo" => $codigo
                            ];

                            $saveAdmin = AdminModel::agregar_adminModel($dataAdmin);


                            if ($saveAdmin->rowCount() >= 1) {


                                $alerta = [
                                    "alerta" => "limpiar",
                                    "titulo" => "",
                                    "texto" => "El Administrador ha sido registrado exitosamente",
                                    "tipo" => "success"
                                ];
                            } else {

                                MainModel::eliminar_cuenta($codigo);
                                $alerta = [
                                    "alerta" => "simple",
                                    "titulo" => "Error Inesperado",
                                    "texto" => "No hemos podido registrar el Administrador",
                                    "tipo" => "error"
                                ];
                            }
                        } else {
                            $alerta = [
                                "alerta" => "simple",
                                "titulo" => "Error Inesperado",
                                "texto" => "No hemos podido registrar el Administrador",
                                "tipo" => "error"
                            ];
                        }
                    }
                }
            }
        }
    }
        return MainModel::sweet_alert($alerta);
    }
    //Controller Paginador Admin
    public function paginador_admin_controller($pagina, $registros, 
    $privilegio, $codigo, $busqueda)
    {

        $pagina = MainModel::limpiar_cadena($pagina);
        $registros = MainModel::limpiar_cadena($registros);
        $privilegio = MainModel::limpiar_cadena($privilegio);
        $codigo = MainModel::limpiar_cadena($codigo);
        $busqueda = MainModel::limpiar_cadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if(isset($busqueda) && $busqueda !=""){
            $consulta = " SELECT SQL_CALC_FOUND_ROWS * FROM admin 
            WHERE ((CuentaCodigo!='$codigo' AND id!='3') AND (AdminNombre LIKE
             '%$busqueda%' OR AdminDNI LIKE '%$busqueda%'))  ORDER BY AdminNombre
            ASC LIMIT $inicio, $registros
            ";

            $paginaURL= "adminsearch";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM admin 
            WHERE CuentaCodigo!='$codigo' AND id!='3' ORDER BY AdminNombre
            ASC LIMIT $inicio, $registros
            ";
            $paginaURL = "adminlist";
        }

        $conexion = MainModel::conexion();
        $datos = $conexion->query($consulta);

        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total / $registros);

        $tabla .= '
        <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">DNI</th>
                    <th class="text-center">NOMBRES</th>
                    <th class="text-center">APELLIDOS</th>
                    <th class="text-center">TELÉFONO</th>';

                    if($privilegio<=2){
                        $tabla .= '
                        <th class="text-center">A. CUENTA</th>
                        <th class="text-center">A. DATOS</th>
                        ';
                  }
                    if($privilegio==1){

                        $tabla.='<th class="text-center">ELIMINAR</th>';
                     }


        $tabla .= '</tr>
            </thead>
            <tbody>';


        if ($total >= 1 && $pagina <= $Npaginas) {

            $contador = $inicio + 1;

            foreach ($datos as $rows) {
                $tabla .= '
               <tr>
               <td>' . $contador . '</td>
               <td>' . $rows['AdminDNI'] . '</td>
               <td>' . $rows['AdminNombre'] . '</td>
               <td>' . $rows['AdminApellido'] . '</td>
               <td>' . $rows['AdminTelefono'] . '</td>';

               if($privilegio<=2){
               $tabla .= '<td>
                   <a href="'.SERVERURL.'myaccount/admin/'.MainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                       <i class="zmdi zmdi-refresh"></i>
                   </a>
               </td>
               <td>
                   <a href="'.SERVERURL.'mydata/admin/'.MainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                       <i class="zmdi zmdi-refresh"></i>
                   </a>
               </td>';
               }
               if($privilegio==1){
               $tabla.='<td>
                   <form action = "'.SERVERURL.'ajax/AdminAjax.php" method="POST"
                   class="FormularioAjax" data-form="delete" entype="multipart/form-data" 
                   autocomplete="off">

                   <input type="hidden" name="codigo-delete" value="'.MainModel::encryption($rows['CuentaCodigo']).'">

                   <input type="hidden" name="privilegio-admin" value="'.MainModel::encryption($privilegio).'">
                       <button type="submit" class="btn btn-danger btn-raised btn-xs">
                           <i class="zmdi zmdi-delete"></i>
                       </button>
                       <div class="RespuestaAjax"></div>
                   </form>
               </td>';
            }

               $tabla .='</tr>';
           
               
                $contador++;
            }
        } else {

            if ($total >= 1) {
                $tabla .= '
                <tr>
                <td colspan = "5">
                <a href= "' . SERVERURL . 'adminlist/" class="btn-sm btn-info">
                Click para recargar
                </a>
                </td>
                </tr>';
            } else {
                $tabla .= '
            <tr>
            <td colspan = "5">No hay registros en el sistema</td>
            </tr>';
            }
        }

        $tabla .= '</tbody></table></div>';
        if ($total >= 1 && $pagina <= $Npaginas) {

            $tabla .='
            <nav class="text-center">
            <ul class="pagination pagination-sm">
            ';

            if($pagina==1){


                $tabla .= '
                <li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>
                ';

            }else{
                $tabla .= '
                <li ><a href="'.SERVERURL.'adminlist/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>
                ';
            }

            for($i=1;$i<=$Npaginas;$i++){

                if($pagina==$i){
                    $tabla .= '
                    <li class="active"><a href="'.SERVERURL.'adminlist/'.$i.'/">'.$i.'</a></li>
                    ';
                }else{
                    $tabla .= '
                    <li><a href="'.SERVERURL.'adminlist/'.$i.'/">'.$i.'</a></li>
                    ';
                }

            }
            if($pagina==$Npaginas){


                $tabla .= '
                <li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i>                </a></li>
                ';

            }else{
                $tabla .= '
                <li ><a href="'.SERVERURL.'adminlist/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i>
                </a></li>
                ';
            }

            $tabla .= '</ul></nav>';
        }

        return $tabla;
    }

    public function eliminar_admin_controller(){
        
        $codigo = MainModel::decryption($_POST['codigo-delete']);
        $Adminprivilegio = MainModel::decryption($_POST['privilegio-admin']); 

        $codigo = MainModel::limpiar_cadena($codigo); 
        $Adminprivilegio = MainModel::limpiar_cadena($Adminprivilegio);


        if($Adminprivilegio==1){
            
           $query1 = MainModel::ejecutar_consulta_simple("SELECT * FROM admin 
           WHERE CuentaCodigo='$codigo'");
           $datosAdmin = $query1->fetch();
           $nu =$query1->rowCount();

           if($datosAdmin['id']>3){ 
               

            $deleteAdmin = AdminModel::eliminar_admin_model($codigo);
            MainModel::eliminar_bitacora($codigo);

            if($deleteAdmin->rowCount()>=1){
                $deleteCuenta = MainModel::eliminar_cuenta($codigo);

                if($deleteCuenta->rowCount()>=1){
                    $alerta = [
                        "alerta" => "recargar",
                        "titulo" => "Administrador Eliminado",
                        "texto" => "El Administrador fue eliminado satisfactoriamente",
                        "tipo" => "success"
                    ]; 
                }else{
                    $alerta = [
                        "alerta" => "simple",
                        "titulo" => "Error Inesperado",
                        "texto" => "No se puede eliminar esta cuenta",
                        "tipo" => "error"
                    ]; 
                }
             }else{
                $alerta = [
                    "alerta" => "simple",
                    "titulo" => "Error Inesperado",
                    "texto" => "No se pudo eliminar el Administrador",
                    "tipo" => "error"
                ]; 
            }

           }else{
            $alerta = [
                "alerta" => "simple",
                "titulo" => "Error Inesperado",
                "texto" => "No podemos eliminar el Administrador principal del sistema",
                "tipo" => "error"
            ];
            
        
            
            
            
           }
        }else{
            $alerta = [
                "alerta" => "simple",
                "titulo" => "Error Inesperado",
                "texto" => "No tienes los permisos necesarios para realizar esta operación",
                "tipo" => "error"
            ];
        }

        return MainModel::sweet_alert($alerta);
    }
}

<?php


class ViewsModel
{

    protected function obtener_vistas_model($view)
    {

        $listaBlanca = [
            "admin", "adminlist", "adminsearch", "book", "bookconfig",
            "bookinfo", "catalog", "category", "categorylist", "client", "clientlist",
            "clientsearch", "company", "companylist", "home", "myaccount",
            "mydata", "provider", "providerlist", "search", "error"
        ];

        if(in_array($view, $listaBlanca)){
            if(is_file("./views/contenidos/".$view.".view.php")){
                $contenido="./views/contenidos/".$view.".view.php";
            }else{
                $contenido="login";
            }
        }elseif($view=="login"){
            $contenido="login";
        }elseif($view=="index"){
            $contenido="login";
        }else{
            $contenido="404";
        }
        return $contenido;
    }
}

<?php

include ('../controlador/Controlador.php');
include ('../dto/UsuarioDTO.php');
include ('../dto/SemilleroDTO.php');

session_start();

$procesar = htmlspecialchars_decode($_POST["proceso"]);
if($procesar=="iniciarSesion")
{
    echo iniciarSesion();
}
if($procesar=="validarSesion")
{
    echo validarSesion();
}
if($procesar=="cerrar")
{
    echo cerrarSesion();
}


function iniciarSesion(){
    $codigo = htmlspecialchars_decode($_POST["codigo"]);
    $pass = htmlspecialchars_decode($_POST["pass"]);
    if($codigo=="admin" && $pass=="admin"){
        $user=new UsuarioDTO;
        $user->setCodigo("admin");
        $user->setNombres("administrador");
        $_SESSION['usuario'] = $user;
        return "administrador";
    }
    $controlador=new Controlador;
    $usuario=$controlador->iniciarSesion($codigo, $pass);
    if($usuario!=null){   
        $_SESSION['usuario'] = $usuario;
        return $usuario->getNombres();
    }
    return 'false';
}
function validarSesion(){
    if (isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        if($usuario->getNombres() == "administrador"){
            return "admin";
        }else{
            return "docente";
        }
    }
    return "false";
}
function cerrarSesion(){
    session_destroy();
    return "¡¡Sesión Cerrada!!";
}



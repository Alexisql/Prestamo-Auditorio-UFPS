<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include ('../controlador/Controlador.php');
include ('../dto/UsuarioDTO.php');
include ('../dto/SemilleroDTO.php');

session_start();
$procesar = htmlspecialchars_decode($_POST["proceso"]);

//AUDITORIO************************************************************
if ($procesar == 'registrar_respuesta_auditorio') {
    echo registrarRespuestaAuditorio();
}
if ($procesar == 'listar_solicitudes_auditorio') {
    echo listarSolicitudesAuditorio();
}
if ($procesar == 'listar_prestamos_auditorio') {
    echo listarPrestamosAuditorio();
}
if ($procesar == 'registrar_prestamo_auditorio') {
    echo registrarPrestamoAuditorio();
}
//SEMILLERO************************************************************
if ($procesar == 'registrar_respuesta_semillero') {
    echo registrarRespuestaSemillero();
}
if ($procesar == 'listar_solicitudes_semillero') {
    echo listarSolicitudesSemillero();
}
if ($procesar == 'listar_prestamos_semillero') {
    echo listarPrestamosSemillero();
}
if ($procesar == 'registrar_prestamo_semillero') {
    echo registrarPrestamoSemillero();
}
//LOS DOS**************************************************************
if ($procesar == 'consulta') {
    echo consulta();
}

//AUDITORIOS************************************************************

function registrarPrestamoAuditorio() {
    $titulo = htmlspecialchars_decode($_POST["titulo"]);
    $cantidadPersonas = $_POST["cantidadPersonas"];
    $fecha_prestamo = htmlspecialchars_decode($_POST["fecha_prestamo"]);
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $telefono = htmlspecialchars_decode($_POST["telefono"]);
    $departamento = htmlspecialchars_decode($_POST["departamento"]);
    $observaciones = htmlspecialchars_decode($_POST["observaciones"]);
    $objetos = htmlspecialchars_decode($_POST["objetos"]);
    $correo = htmlspecialchars_decode($_POST["correo"]);
    echo registrar_auditorio($titulo, $cantidadPersonas, $fecha_prestamo, $hora_inicio, $hora_fin, $telefono, $departamento, $observaciones, $correo, $objetos);
}


function registrarRespuestaAuditorio() {
    $id = $_POST["id"];
    $observaciones = htmlspecialchars_decode($_POST["observaciones"]);
    $respuesta = htmlspecialchars_decode($_POST["respuesta"]);
    $correo = htmlspecialchars_decode($_POST["correo"]);
    $codigo = htmlspecialchars_decode($_POST["codigo"]);
    $controlador = new Controlador;
    $pa = new AuditorioDTO;
    $pa->setId($id);
    $pa->setObservaciones_respuesta($observaciones);
    $pa->setRespuesta($respuesta);
    $pa->setCorreo($correo);
    $pa->setCodigo_docente($codigo);
    return $controlador->registrarRespuestaAuditorio($pa);
}

function listarSolicitudesAuditorio() {
    $controlador = new Controlador;
    $lista = $controlador->listarSolicitudesAuditorio();
    $_SESSION['sa'] = $lista;
    echo json_encode($lista);
}

function listarPrestamosAuditorio() {
    $controlador = new Controlador;
    $lista = $controlador->listarPrestamosAuditorio();
    $_SESSION['pa'] = $lista;
    echo json_encode($lista);
}

//SEMILLERO************************************************************

function registrarPrestamoSemillero() {
    $codigo_docente=$_SESSION['usuario']->getCodigo();
    $grupo_semillero=htmlspecialchars_decode($_POST['grupo_semillero']);
    $cantidadPersonas=$_POST['cantidadPersonas'];
    $fecha_prestamo=htmlspecialchars_decode($_POST['fecha_prestamo']);
    $hora_inicio=$_POST['hora_inicio'];
    $hora_fin=$_POST['hora_fin'];
    $telefono=htmlspecialchars_decode($_POST['telefono']);
    $departamento=htmlspecialchars_decode($_POST['departamento']);
    $observaciones=htmlspecialchars_decode($_POST['observaciones']);
    $correo=htmlspecialchars_decode($_POST['correo']);
    echo registrarSemillero($codigo_docente, $grupo_semillero, $cantidadPersonas, 
            $fecha_prestamo, $hora_inicio, $hora_fin, $telefono, 
            $departamento, $observaciones, $correo);
}

function registrarRespuestaSemillero() {
    $id = $_POST["id"];
    $observaciones = htmlspecialchars_decode($_POST["observaciones"]);
    $respuesta = htmlspecialchars_decode($_POST["respuesta"]);
    $correo = htmlspecialchars_decode($_POST["correo"]);
    $codigo = htmlspecialchars_decode($_POST["codigo"]);
    $controlador = new Controlador;
    $pa = new SemilleroDTO;
    $pa->setId($id);
    $pa->setObservaciones_respuesta($observaciones);
    $pa->setRespuesta($respuesta);
    $pa->setCorreo($correo);
    $pa->setCodigo_docente($codigo);
    return $controlador->registarRespuestaSemillero($pa);
}

function listarSolicitudesSemillero() {
    $controlador = new Controlador;
    $lista = $controlador->listarSolicitudesSemillero();
    $_SESSION['ss'] = $lista;
    echo json_encode($lista);
}

function listarPrestamosSemillero() {
    $controlador = new Controlador;
    $lista = $controlador->listarPrestamosSemilleros();
    $_SESSION['ps'] = $lista;
    echo json_encode($lista);
}

//LOS DOS************************************************************
function consulta() {
    $id = $_POST['id'];
    $consulta = $_POST['consulta'];
    $lista = $_SESSION[$consulta];
    foreach ($lista as $dato) {
        if ($dato->getId() == $id) {
            return json_encode($dato);
        }
    }
}

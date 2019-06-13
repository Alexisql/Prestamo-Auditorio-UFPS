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
//AUDITORIO*********************************************************************
if ($procesar == 'registrar_prestamo_auditorio') {
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
if ($procesar == 'listar_solicitudes_auditorio_docente') {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    echo listarSolicitudesAuditorio($codigo_docente);
}
if ($procesar == 'listar_prestamos_auditorio_docente') {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    echo listarPrestamosAuditorio($codigo_docente);
}
if ($procesar == 'cancelar_auditorio') {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    $id=$_POST['id'];
    echo cancelarPrestamoAuditorio($id, $codigo_docente);
}

//SEMILLERO*********************************************************************

if ($procesar == 'registrar_prestamo_semillero') {
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
if ($procesar == 'listar_solicitudes_semilleros_docente') {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    echo listarSolicitudesSemillero($codigo_docente);
}
if ($procesar == 'listar_prestamos_semilleros_docente') {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    echo listarPrestamosSemillero($codigo_docente);
}
if ($procesar == 'cancelar_semillero') {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    $id=$_POST['id'];
    echo cancelarPrestamoSemillero($id, $codigo_docente);
}

//LOS DOS************************************************************************
if ($procesar == 'consultar_dato') {
    $id = $_POST['id'];
    $consulta = $_POST['consulta'];
    echo cargarConsulta($id, $consulta);
}

//FUNCIONES AUDITRIO**************************************************************
function registrar_auditorio($titulo, $cantidadPersonas, $fecha_prestamo, $hora_inicio, $hora_fin, $telefono, $departamento, $observaciones, $correo, $objetos) {
    $codigo_docente = $_SESSION['usuario']->getCodigo();
    $pa = new AuditorioDTO;
    $pa->setCodigo_docente($codigo_docente);
    $pa->setTitulo($titulo);
    $pa->setCantidad_personas($cantidadPersonas);
    $pa->setFecha_prestamo(new DateTime($fecha_prestamo));
    $pa->setHora_inicio(intval(explode(":", $hora_inicio)[0]));
    $pa->setHora_fin(intval(explode(":", $hora_fin)[0]));
    $pa->setTelefono($telefono);
    $pa->setDepartamento($departamento);
    $pa->setObservaciones_prestamo($observaciones);
    $pa->setCorreo($correo);
    $pa->setObjetos($objetos);
    $controlador = new Controlador;

    echo $controlador->registrarSolicitudAuditorio($pa);
}

function listarSolicitudesAuditorio($codigo_docente) {
    $controlador = new Controlador;
    $lista = $controlador->listarSolicitudesDocenteAuditorio($codigo_docente);
    $_SESSION['sa'] = $lista;
    echo json_encode($lista);
}

function listarPrestamosAuditorio($codigo_docente) {
    $controlador = new Controlador;
    $lista = $controlador->listarPrestamosDocenteAuditorio($codigo_docente);
    $_SESSION['pa'] = $lista;
    echo json_encode($lista);
}

function cancelarPrestamoAuditorio($id, $codigo_docente) {
    $controlador=new Controlador;
    return $controlador->cancelarSolicitudAuditorioDocente($id, $codigo_docente);
}

//FUNCIONES SEMILLERO*************************************************************
function registrarSemillero($codigo_docente, $grupo_semillero, $cantidadPersonas, 
        $fecha_prestamo, $hora_inicio, $hora_fin, $telefono, 
        $departamento, $observaciones, $correo) {
    $dto=new SemilleroDTO;
    $dto->setCodigo_docente($codigo_docente);
    $dto->setCurso_grupo($grupo_semillero);
    $dto->setCantidad_personas($cantidadPersonas);
    $dto->setFecha_prestamo(new DateTime($fecha_prestamo));
    $dto->setHora_inicio($hora_inicio);
    $dto->setHora_fin($hora_fin);
    $dto->setTelefono($telefono);
    $dto->setDepartamento($departamento);
    $dto->setObservaciones_prestamo($observaciones);
    $dto->setCorreo($correo);
    $controlador=new Controlador;
    echo $controlador->registarSolicitudesSemillero($dto);
}

function listarSolicitudesSemillero($codigo_docente) {
    $controlador = new Controlador;
    $lista = $controlador->listarSolicitudesDocenteSemillero($codigo_docente);
    $_SESSION['ss'] = $lista;
    echo json_encode($lista);
}

function listarPrestamosSemillero($codigo_docente) {
    $controlador = new Controlador;
    $lista = $controlador->listarPrestamosDocentesSemilleros($codigo_docente);
    $_SESSION['ps'] = $lista;
    echo json_encode($lista);
}

function cancelarPrestamoSemillero($id, $codigo_docente) {
    $controlador=new Controlador;
    return $controlador->cancelarSolicitudSemilleroDocente($id, $codigo_docente);
}

//LOS DOS**************************************************************************
function cargarConsulta($id, $consulta) {
    $lista = $_SESSION[$consulta];
    foreach ($lista as $dato) {
        if ($dato->getId() == $id) {
            return json_encode($dato);
        }
    }
}
?>


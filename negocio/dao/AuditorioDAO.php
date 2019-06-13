<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("../dto/AuditorioDTO.php");
include('../conexion/Conexion.php');

class AuditorioDAO {

    private $tabla = "prestamo_auditorio";

    function registrarSolicitud(AuditorioDTO $pa, mysqli $conn) {
        $stmt = null;
        try {
            $sql = "INSERT INTO " . $this->tabla . " (codigo_docente, fecha_solicitud, 
            titulo, cantidad_personas, fecha_prestamo, 
            hora_inicio, hora_fin, objetos_prestamo, observaciones_prestamo, 
            telefono, departamento, correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssisiisssss", $pa->getCodigo_docente(), $pa->getFecha_solicitud()->format('Y-m-d H:i:s'), $pa->getTitulo(), $pa->getCantidad_personas(), $pa->getFecha_prestamo()->format('Y-m-d H:i:s'), $pa->getHora_inicio(), $pa->getHora_fin(), $pa->getObjetos(), $pa->getObservaciones_prestamo(), $pa->getTelefono(), $pa->getDepartamento(), $pa->getCorreo());
            if ($stmt->execute() === TRUE) {
                return "true";
            }
            return "Error: " . $sql . "<br>" . $conn->error;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }

    function registrarRespuesta(AuditorioDTO $pa, mysqli $conn) {
        $stmt = null;
        try {
            $sql = "UPDATE prestamo_auditorio SET" .
                    " respuesta=?, fecha_respuesta=?, observaciones_respuesta=?" .
                    " WHERE ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", 
                    $pa->getRespuesta(), 
                    $pa->getFecha_respuesta()->format('Y-m-d H:i:s'), 
                    $pa->getObservaciones_respuesta(), 
                    $pa->getId());
            if ($stmt->execute() == TRUE) {
                return true;
            }
            return false;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }

    function listarSolicitudesDocente($codigo_docente, mysqli $conn) {
        $stmt = null;
        try {
            $sql = "SELECT * FROM prestamo_auditorio " . "WHERE codigo_docente=? AND respuesta IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $codigo_docente);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new AuditorioDTO;
                $dto->setId($myrow['ID']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setTitulo($myrow['titulo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObjetos($myrow['objetos_prestamo']);
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setTelefono($myrow['telefono']);
                $dto->setDepartamento($myrow['departamento']);
                $dto->setCorreo($myrow['correo']);
                $array[]=$dto;
            }
            return $array;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }
    
    function listarSolicitudes(mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "SELECT * FROM prestamo_auditorio " . "WHERE respuesta IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new AuditorioDTO;
                $dto->setId($myrow['ID']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setTitulo($myrow['titulo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObjetos($myrow['objetos_prestamo']);
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setTelefono($myrow['telefono']);
                $dto->setDepartamento($myrow['departamento']);
                $dto->setCorreo($myrow['correo']);
                $array[]=$dto;
            }
            return $array;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }
    
    function listarPrestamosDocente($codigo_docente, mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "SELECT * FROM prestamo_auditorio "
                    . "WHERE codigo_docente=? AND respuesta IS NOT NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $codigo_docente);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new AuditorioDTO;
                $dto->setId($myrow['ID']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setTitulo($myrow['titulo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObjetos($myrow['objetos_prestamo']);
                $dto->setRespuesta($myrow['respuesta']);
                $dto->setFecha_respuesta(new DateTime($myrow['fecha_respuesta']));
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setObservaciones_respuesta($myrow['observaciones_respuesta']);
                $dto->setTelefono($myrow['telefono']);
                $dto->setDepartamento($myrow['departamento']);
                $dto->setCorreo($myrow['correo']);
                $array[]=$dto;
            }
            return $array;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }
    
    function listarPrestamos(mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "SELECT * FROM prestamo_auditorio "
                    . "WHERE respuesta IS NOT NULL";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new AuditorioDTO;
                $dto->setId($myrow['ID']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setTitulo($myrow['titulo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObjetos($myrow['objetos_prestamo']);
                $dto->setRespuesta($myrow['respuesta']);
                $dto->setFecha_respuesta(new DateTime($myrow['fecha_respuesta']));
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setObservaciones_respuesta($myrow['observaciones_respuesta']);
                $dto->setTelefono($myrow['telefono']);
                $dto->setDepartamento($myrow['departamento']);
                $dto->setCorreo($myrow['correo']);
                $array[]=$dto;
            }
            return $array;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }

    function buscarPorFecha(DateTime $fecha, mysqli $conn) {
        $sql = "SELECT * FROM " . $this->tabla . " WHERE fecha_prestamo=?";
        $stmt = $conn->prepare($sql);
        $fechaFormat = $fecha->format("Y-m-d H:i:s");
        $stmt->bind_param("s", $fechaFormat);
        $stmt->execute();
        $result = $stmt->get_result();
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $pa = new AuditorioDTO;
            $pa->setHora_inicio($row['hora_inicio']);
            $pa->setHora_fin($row['hora_fin']);
            $pa->setRespuesta($row['respuesta']);
            $arr[] = $pa;
        }

        $stmt->close();
        return $arr;
    }
    
    function eliminarSoliciud($id, $codigo_docente, mysqli $conn )
    {
        $stmt = null;
        try {
            $sql = "DELETE FROM prestamo_auditorio WHERE id=? AND codigo_docente=? AND respuesta IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", 
                    $id, 
                    $codigo_docente);
            if ($stmt->execute() == TRUE) {
                return true;
            }
            return false;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }

}

?>
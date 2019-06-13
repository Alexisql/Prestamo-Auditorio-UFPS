<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SemilleroDAO {

    //put your code here
    
    function registrarSolicitud(SemilleroDTO $se, mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "INSERT INTO prestamo_semilleros (fecha_solicitud, curso_grupo,"
                    . "codigo_docente, cantidad_personas, departamento, telefono_celular, hora_inicio, hora_fin, "
                    . "observaciones_prestamo, fecha_prestamo, correo) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssissiisss", 
                    $se->getFecha_solicitud()->format('Y-m-d H:i:s'), 
                    $se->getCurso_grupo(),  
                    $se->getCodigo_docente(),  
                    $se->getCantidad_personas(), 
                    $se->getDepartamento(), 
                    $se->getTelefono(), 
                    $se->getHora_inicio(), $se->getHora_fin(),                  
                    $se->getObservaciones_prestamo(), 
                    $se->getFecha_prestamo()->format('Y-m-d H:i:s'),                     
                    $se->getCorreo());
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
    
    function registrarRespuesta(SemilleroDTO $se, mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "UPDATE prestamo_semilleros SET respuesta=?, fecha_respuesta=?, observaciones_respuesta=? "
                    . "WHERE ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", 
                    $se->getRespuesta(), 
                    $se->getFecha_respuesta()->format('Y-m-d H:i:s'), 
                    $se->getObservaciones_respuesta(), 
                    $se->getId());
            if ($stmt->execute() == TRUE) {
                return "true";
            }
            return "registro fallido";
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }
    
    function listarSolicitudesDocente($codigo_docente, mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "SELECT * FROM prestamo_semilleros "
                    . "WHERE codigo_docente=? AND respuesta IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $codigo_docente);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new SemilleroDTO();
                $dto->setId($myrow['id']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setCurso_grupo($myrow['curso_grupo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setTelefono($myrow['telefono_celular']);
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
    
    function listaSolicitudes(mysqli $conn)
    {
        $stmt = null;
        try {
            $sql = "SELECT * FROM prestamo_semilleros "
                    . "WHERE respuesta IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new SemilleroDTO();
                $dto->setId($myrow['id']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setCurso_grupo($myrow['curso_grupo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setTelefono($myrow['telefono_celular']);
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
            $sql = "SELECT * FROM prestamo_semilleros WHERE codigo_docente=? AND respuesta IS NOT NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $codigo_docente);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new SemilleroDTO();
                $dto->setId($myrow['id']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setCurso_grupo($myrow['curso_grupo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setTelefono($myrow['telefono_celular']);
                $dto->setDepartamento($myrow['departamento']);
                $dto->setCorreo($myrow['correo']);
                $dto->setRespuesta($myrow['respuesta']);
                $dto->setObservaciones_respuesta($myrow['observaciones_respuesta']);
                $dto->setFecha_respuesta(new DateTime($myrow['fecha_respuesta']));
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
            $sql = "SELECT * FROM prestamo_semilleros WHERE respuesta IS NOT NULL";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $array=array();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new SemilleroDTO();
                $dto->setId($myrow['id']);
                $dto->setCodigo_docente($myrow['codigo_docente']);
                $dto->setFecha_solicitud(new DateTime($myrow['fecha_solicitud']));
                $dto->setCurso_grupo($myrow['curso_grupo']);
                $dto->setCantidad_personas($myrow['cantidad_personas']);
                $dto->setFecha_prestamo(new DateTime($myrow['fecha_prestamo']));
                $dto->setHora_inicio($myrow['hora_inicio']);
                $dto->setHora_fin($myrow['hora_fin']);
                $dto->setObservaciones_prestamo($myrow['observaciones_prestamo']);
                $dto->setTelefono($myrow['telefono_celular']);
                $dto->setDepartamento($myrow['departamento']);
                $dto->setCorreo($myrow['correo']);
                $dto->setRespuesta($myrow['respuesta']);
                $dto->setObservaciones_respuesta($myrow['observaciones_respuesta']);
                $dto->setFecha_respuesta(new DateTime($myrow['fecha_respuesta']));
                $array[]=$dto;
            }
            return $array;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }

    
    function buscarPorFecha($fecha, mysqli $conn)
    {
        $sql ="SELECT * FROM prestamo_semilleros WHERE fecha_prestamo=?";
        $stmt = $conn->prepare($sql);
        $fechaFormat = $fecha->format("Y-m-d H:i:s");
        $stmt->bind_param("s", $fechaFormat);
        $stmt->execute();
        $result = $stmt->get_result();
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $pa = new SemilleroDTO;
            $pa->setHora_inicio($row['hora_inicio']);
            $pa->setHora_fin($row['hora_fin']);
            $pa->setRespuesta($row['respuesta']);
            $arr[] = $pa;
        }

        $stmt->close();
        return $arr;
    }
    function eliminarSolicitud($id, $codigo_docente, mysqli $conn){
        $stmt = null;
        try {
            $sql = "DELETE FROM prestamo_semilleros WHERE id=? AND codigo_docente=? AND respuesta IS NULL";
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

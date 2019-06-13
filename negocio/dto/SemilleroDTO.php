<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SemilleroDTO implements JsonSerializable {

    private $id;
    private $codigo_docente;
    private $fecha_solicitud;
    private $curso_grupo;
    private $departamento;
    private $telefono;
    private $fecha_prestamo;
    private $hora_inicio;
    private $hora_fin;
    private $respuesta;
    private $fecha_respuesta;
    private $observaciones_prestamo;
    private $observaciones_respuesta;
    private $cantidad_personas;
    private $correo;

    public function jsonSerialize() {
        $fs = '';
        $fp = '';
        $fr = '';
        if ($this->fecha_solicitud != null) {
            $fs = $this->fecha_solicitud->format('Y-m-d');
        }
        if ($this->fecha_prestamo != null) {
            $fp = $this->fecha_prestamo->format('Y-m-d');
        }
        if ($this->fecha_respuesta != null) {
            $fr = $this->fecha_respuesta->format('Y-m-d');
        }
        return array(
            'id' => $this->id,
            'codigo_docente' => $this->codigo_docente,
            'fecha_solicitud' => $fs,
            'curso_grupo' => $this->curso_grupo,
            'departamento' => $this->departamento,
            'telefono' => $this->telefono,
            'fecha_prestamo' => $fp,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'respuesta' => $this->respuesta,
            'fecha_respuesta' => $fr,
            'observaciones_prestamo' => $this->observaciones_prestamo,
            'observaciones_respuesta' => $this->observaciones_respuesta,
            'cantidad_personas' => $this->cantidad_personas,
            'correo' => $this->correo,
        );
    }

    function getId() {
        return $this->id;
    }

    function getCodigo_docente() {
        return $this->codigo_docente;
    }

    function getFecha_solicitud() {
        return $this->fecha_solicitud;
    }

    function getCurso_grupo() {
        return $this->curso_grupo;
    }

    function getDepartamento() {
        return $this->departamento;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getFecha_prestamo() {
        return $this->fecha_prestamo;
    }

    function getHora_inicio() {
        return $this->hora_inicio;
    }

    function getHora_fin() {
        return $this->hora_fin;
    }

    function getRespuesta() {
        return $this->respuesta;
    }

    function getFecha_respuesta() {
        return $this->fecha_respuesta;
    }

    function getObservaciones_prestamo() {
        return $this->observaciones_prestamo;
    }

    function getObservaciones_respuesta() {
        return $this->observaciones_respuesta;
    }

    function getCantidad_personas() {
        return $this->cantidad_personas;
    }

    function getCorreo() {
        return $this->correo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo_docente($codigo_docente) {
        $this->codigo_docente = $codigo_docente;
    }

    function setFecha_solicitud($fecha_solicitud) {
        $this->fecha_solicitud = $fecha_solicitud;
    }

    function setCurso_grupo($curso_grupo) {
        $this->curso_grupo = $curso_grupo;
    }

    function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setFecha_prestamo($fecha_prestamo) {
        $this->fecha_prestamo = $fecha_prestamo;
    }

    function setHora_inicio($hora_inicio) {
        $this->hora_inicio = $hora_inicio;
    }

    function setHora_fin($hora_fin) {
        $this->hora_fin = $hora_fin;
    }

    function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
    }

    function setFecha_respuesta($fecha_respuesta) {
        $this->fecha_respuesta = $fecha_respuesta;
    }

    function setObservaciones_prestamo($observaciones_prestamo) {
        $this->observaciones_prestamo = $observaciones_prestamo;
    }

    function setObservaciones_respuesta($observaciones_respuesta) {
        $this->observaciones_respuesta = $observaciones_respuesta;
    }

    function setCantidad_personas($cantidad_personas) {
        $this->cantidad_personas = $cantidad_personas;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

}

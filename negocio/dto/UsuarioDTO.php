<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuarioDTO {
    private $borrowernumbre, $codigo, $nombres, $apellidos, $email, 
            $telefono, $celular, $tipo_usuario, $facultad, $programa, $password;
    
    
    function getBorrowernumbre() {
        return $this->borrowernumbre;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getTipo_usuario() {
        return $this->tipo_usuario;
    }

    function getFacultad() {
        return $this->facultad;
    }

    function getPrograma() {
        return $this->programa;
    }

    function getPassword(){
        return $this->password;
    }

    function setBorrowernumbre($borrowernumbre) {
        $this->borrowernumbre = $borrowernumbre;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setTipo_usuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }

    function setFacultad($facultad) {
        $this->facultad = $facultad;
    }

    function setPrograma($programa) {
        $this->programa = $programa;
    }

    function setPassword($password) {
        $this->password = $password;
    }
}

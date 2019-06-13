<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuarioDAO {
    //put your code here
    function consultarUsuario(mysqli $conn, $codigo)
    {
         $stmt = null;
        try {
            $sql = "SELECT * FROM usuarios WHERE codigo_usuario=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($myrow = $result->fetch_assoc()) {
                $dto=new UsuarioDTO();
                $dto->setBorrowernumbre($myrow['borrowernumber']);
                $dto->setCodigo($myrow['codigo_usuario']);
                $dto->setApellidos($myrow['apellidos']);
                $dto->setNombres($myrow['nombres']);
                $dto->setEmail($myrow['email']);
                $dto->setTelefono($myrow['phone']);
                $dto->setCelular($myrow['mobile']);
                $dto->setFacultad($myrow['facultad']);
                $dto->setPrograma($myrow['programa']);
                $dto->setTipo_usuario($myrow['tipo_usuario']);
                $dto->setPassword($myrow['password']);
                return $dto;
            }
        }finally{
            if ($stmt != null) {
                $stmt->close();
            }
        }
    }
}

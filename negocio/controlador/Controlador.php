<?php

include('../dao/AuditorioDAO.php');
include('../dao/UsuarioDAO.php');
include('../util/Fecha.php');
include('../dao/SemilleroDAO.php');
include_once ('../mail/Mail.php');

class Controlador {

    //put your code here
    //AUDITORIO**********************************************************
    function registrarSolicitudAuditorio(AuditorioDTO $pa) {
        $conn = Conexion::obtenerConexion();
        try {
            $pa->setFecha_solicitud(Fecha::obtenerHoraActual());
            $interval = $pa->getFecha_solicitud()->diff($pa->getFecha_prestamo());
            if ($interval->format('%R%a') < 1) {
                return "Debe apartar el auditorio con al menos dos días de anticipación";
            }
            if ($pa->getCantidad_personas() > 200) {
                return "El auditorio tiene una capacidad máxima de 200 personas";
            }
            if ($pa->getHora_inicio() > $pa->getHora_fin()) {
                return "La hora de inicio de evento debe ser menor a la hora final del evento";
            }
            if ($conn != null) {
                $dao = new AuditorioDAO;
                $lista = $dao->buscarPorFecha($pa->getFecha_prestamo(), $conn);
                foreach ($lista as $dato) {
                    if (($pa->getHora_inicio() >= $dato->getHora_inicio() && $pa->getHora_inicio() < $dato->getHora_fin()) || ($pa->getHora_fin() > $dato->getHora_inicio() && $pa->getHora_fin() <= $dato->getHora_fin())) {
                        if ($dato->getRespuesta() == null) {
                            return "Ya hay una solicitud pendiente por aprobación para esa fecha";
                        }
                        if ($dato->getRespuesta() == "Aprobado") {
                            return "El auditorio ya esta prestado en ese horario";
                        }
                    }
                }
                $resultado = $dao->registrarSolicitud($pa, $conn);
                return $resultado;
            }
        } finally {
            if ($conn != null) {
                $conn->close();
            }
        }
    }

    function registrarRespuestaAuditorio(AuditorioDTO $pa) {
        $pa->setFecha_respuesta(Fecha::obtenerHoraActual());
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new AuditorioDAO;
            //$this->enviarCorreoAuditorio($pa);
            return $dao->registrarRespuesta($pa, $conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function enviarCorreoAuditorio(AuditorioDTO $pa){
        $conn = Conexion::obtenerConexion();
        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->consultarUsuario($conn, $pa->getCodigo_docente());
        if($usuario != null){
            $nombre = $usuario->getNombres();
            $apellido = $usuario->getApellidos();
            $auditorio = "BECL";
            $email = new Mail();
            $email->notificacionAuditorio($nombre,$apellido,$auditorio,$pa->getCorreo(),$pa->getRespuesta(),$pa->getObservaciones_respuesta());
        }
    }

    function listarSolicitudesDocenteAuditorio($codigo_docente) {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new AuditorioDAO;
            return $dao->listarSolicitudesDocente($codigo_docente, $conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function listarSolicitudesAuditorio() {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new AuditorioDAO;
            return $dao->listarSolicitudes($conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function listarPrestamosDocenteAuditorio($codigo_docente) {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new AuditorioDAO;
            return $dao->listarPrestamosDocente($codigo_docente, $conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function listarPrestamosAuditorio() {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new AuditorioDAO;
            return $dao->listarPrestamos($conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function cancelarSolicitudAuditorioDocente($id, $codigo_docente) {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new AuditorioDAO;
            if ($dao->eliminarSoliciud($id, $codigo_docente, $conn)) {
                return "true";
            }
            return "No se puddo eliminar la solicitud";
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    //SEMILLERO*************************************************************

    function registarSolicitudesSemillero(SemilleroDTO $ps) {
        $conn = Conexion::obtenerConexion();
        try {
            $ps->setFecha_solicitud(Fecha::obtenerHoraActual());
            $interval = $ps->getFecha_solicitud()->diff($ps->getFecha_prestamo());
            if ($interval->format('%R%a') < 1) {
                return "Debe apartar el auditorio con al menos dos días de anticipación";
            }
            if ($ps->getCantidad_personas() > 20) {
                return "El auditorio tiene una capacidad máxima de 20 personas";
            }
            if ($ps->getHora_inicio() > $ps->getHora_fin()) {
                return "La hora de inicio de evento debe ser menor a la hora final del evento";
            }
            if ($conn != null) {
                $dao = new SemilleroDAO;
                $lista = $dao->buscarPorFecha($ps->getFecha_prestamo(), $conn);
                foreach ($lista as $dato) {
                    if (($ps->getHora_inicio() >= $dato->getHora_inicio() && $ps->getHora_inicio() < $dato->getHora_fin()) || ($ps->getHora_fin() > $dato->getHora_inicio() && $ps->getHora_fin() <= $dato->getHora_fin())) {
                        if ($dato->getRespuesta() == null) {
                            return "Ya hay una solicitud pendiente por aprobación para esa fecha";
                        }
                        if ($dato->getRespuesta() == "Aprobado") {
                            return "El auditorio ya esta prestado en ese horario";
                        }
                    }
                }

                $resultado = $dao->registrarSolicitud($ps, $conn);
                return $resultado;
            }
        } finally {
            if ($conn != null) {
                $conn->close();
            }
        }
    }

    function registarRespuestaSemillero(SemilleroDTO $ps) {
        $ps->setFecha_respuesta(Fecha::obtenerHoraActual());
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new SemilleroDAO;
            //$this->enviarCorreoSemillero($ps);
            return $dao->registrarRespuesta($ps, $conn);
        } finally {
            $conn->close();
        }
    }

    function enviarCorreoSemillero(SemilleroDTO $ps){
        $conn = Conexion::obtenerConexion();
        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->consultarUsuario($conn, $ps->getCodigo_docente());
        if($usuario != null){
            $nombre = $usuario->getNombres();
            $apellido = $usuario->getApellidos();
            $auditorio = "Semilleros";
            $email = new Mail();
            $email->notificacionAuditorio($nombre,$apellido,$auditorio,$ps->getCorreo(),$ps->getRespuesta(),$ps->getObservaciones_respuesta());
        }
    }

    function listarSolicitudesDocenteSemillero($codigo_docente) {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new SemilleroDAO();
            return $dao->listarSolicitudesDocente($codigo_docente, $conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function listarSolicitudesSemillero() {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new SemilleroDAO();
            return $dao->listaSolicitudes($conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function listarPrestamosDocentesSemilleros($codigo_docente) {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new SemilleroDAO();
            return $dao->listarPrestamosDocente($codigo_docente, $conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function listarPrestamosSemilleros() {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new SemilleroDAO();
            return $dao->listarPrestamos($conn);
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

    function cancelarSolicitudSemilleroDocente($id, $codigo_docente) {
        $conn = Conexion::obtenerConexion();
        try {
            $dao = new SemilleroDAO;
            if ($dao->eliminarSolicitud($id, $codigo_docente, $conn)) {
                return "true";
            }
            return "No se puddo eliminar la solicitud";
        } catch (Exception $ex) {
            
        } finally {
            $conn->close();
        }
    }

//USUARIO****************************************************************
    function iniciarSesion($codigo, $pass) {
        $conn = Conexion::obtenerConexion();
        try{
            $dao=new UsuarioDAO;
            $usuario= $dao->consultarUsuario($conn, $codigo);
            if($usuario != null && $usuario->getPassword()==$pass && $usuario->getTipo_usuario()=="Docente")
            {
                return $usuario;
            }
            return null;
        } finally {
            $conn->close();
        }
    }
}
?>

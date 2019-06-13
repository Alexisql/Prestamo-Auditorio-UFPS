<?php //

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author Lenovo
 */
class Conexion {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "datosbecl";
    static function obtenerConexion(){
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        $acentos = $conn->query("SET NAMES 'utf8'");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            return "error";
        }
        return $conn;
    }
    
    static function cerrarConexion(mysqli $conn)
    {
        if($conn!=null){
            $conn->close();
        }
    }
}

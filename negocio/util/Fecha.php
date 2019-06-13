<?php

class Fecha {
    static function obtenerHoraActual()
    {
        $fecha=new DateTime();
        $fecha->sub(new DateInterval('PT7H'));
        return $fecha;
    }
}

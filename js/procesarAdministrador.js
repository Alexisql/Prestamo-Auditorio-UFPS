/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
cargarTablas();

function cargarTablas()
{
    $(document).ready(function () {
        listarSolicitudesAuditorio();
        listarSolicitudesSemillero();
        listarPrestamosAuditorio();
        listarPrestamosSemillero();
    });
}

function prestar_auditorio_modal()
{
    openModal('modal-prestamo-aditorio');
}


function prestar_auditorio()
{
    proceso = "registrar_prestamo_auditorio";
    titulo = $("#titulo").val();
    cantidadPersonas = $("#cantidadPersonas").val();
    fecha_prestamo = $("#fecha_prestamo").val();
    hora_inicio = $('#hora_inicio option:selected').text();
    hora_fin = $('#hora_fin option:selected').text();
    telefono = $("#telefono").val();
    departamento = $("#departamento").val();
    observaciones = $("#observaciones").val();
    correo = $("#correo").val();
    var objetos = "";
    $("input[name='objeto']:checked").each(function ()
    {
        objetos += $(this).val() + ":";
    });
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: "registrar_prestamo_auditorio",
            titulo: titulo,
            cantidadPersonas: cantidadPersonas,
            fecha_prestamo: fecha_prestamo,
            hora_inicio: hora_inicio,
            hora_fin: hora_fin,
            telefono: telefono,
            departamento: departamento,
            observaciones: observaciones,
            objetos: objetos,
            correo: correo
        }
    }).done(function (sub) {
        confirmarSolicitudAuditorio(sub);
    });
}


function listarSolicitudesAuditorio()
{
    proceso = "listar_solicitudes_auditorio";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        for (var i = 0; i < resultado.length; i++) {
            resultado[i].fecha_solicitud = resultado[i].fecha_solicitud.toString().substring(0, 12);
            resultado[i].fecha_prestamo = resultado[i].fecha_prestamo.toString().substring(0, 12);
            resultado[i].hora_inicio = resultado[i].hora_inicio.toString() + ":00";
            resultado[i].hora_fin = resultado[i].hora_fin.toString() + ":00";
        }
        $('#prestamo_auditorio_tabla').DataTable({
            data: resultado,
            columns: [
                {data: 'id'},
                {data: 'fecha_solicitud'},
                {data: 'titulo'},
                {data: 'fecha_prestamo'},
                {data: 'hora_inicio'},
                {data: 'hora_fin'}
            ]
        });
        var patable = $('#prestamo_auditorio_tabla').DataTable();        

        $('#prestamo_auditorio_tabla tbody').on('click', 'tr', function () {
            var data = patable.row(this).data();
            cargarDetalleSolicitudAuditorio(data.id, "sa");
        });
    });
}

function cargarDetalleSolicitudAuditorio(id, consulta) {
    proceso = "consulta";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#titulo_ra').val(resultado.titulo);
        $('#id_ra').val(resultado.id);
        $('#codigo_docente_ra').val(resultado.codigo_docente);
        $('#cantidadPersonas_ra').val(resultado.cantidad_personas);
        $('#hora_inicio_ra').val(resultado.hora_inicio + ":00");
        $('#hora_fin_ra').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_ra').val(resultado.fecha_prestamo.toString().substring(0, 12));
        var objetos = resultado.objetos.toString().split(':');
        $("input[name='objeto_ra']").each(function ()
        {
            for (var i = 0; i < objetos.length; i++) {
                if(objetos[i]==$(this).val()){
                    $(this).prop( "checked", true);
                }
            }            
        });
        $('#telefono_ra').val(resultado.telefono);
        $('#correo_ra').val(resultado.correo);
        $('#departamento_ra').val(resultado.departamento);
        $('#observaciones_prestamo_ra').val(resultado.observaciones_prestamo);
        openModal('modal-responder-aditorio');
    });
}

function cargarDetalleHistoricoAuditorio(id, consulta) {
    proceso = "consulta";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#titulo_ca').val(resultado.titulo);
        $('#id_ca').val(resultado.id);
        $('#codigo_docente_ca').val(resultado.codigo_docente);
        $('#cantidadPersonas_ca').val(resultado.cantidad_personas);
        $('#hora_inicio_ca').val(resultado.hora_inicio + ":00");
        $('#hora_fin_ca').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_ca').val(resultado.fecha_prestamo);
        $('#fecha_respuesta_ca').val(resultado.fecha_respuesta);
        var objetos = resultado.objetos.toString().split(':');
        $("input[name='objeto_ca']").each(function ()
        {
            for (var i = 0; i < objetos.length; i++) {
                if(objetos[i]==$(this).val()){
                    $(this).prop( "checked", true);
                }
            }            
        });
        var respuesta = resultado.respuesta;
        $("input[name='respuesta_ca']").each(function ()
        {
                if(respuesta==$(this).val()){
                    $(this).prop( "checked", true);
                }        
        });
        //aquí vienen los objetos
        $('#telefono_ca').val(resultado.telefono);
        $('#correo_ca').val(resultado.correo);
        $('#departamento_ca').val(resultado.departamento);
        $('#observaciones_prestamo_ca').val(resultado.observaciones_prestamo);
        $('#observaciones_respuesta_ca').val(resultado.observaciones_respuesta);
        openModal('modal-consulta-aditorio');
    });


}

function cargarDetalleSolicitudSemillero(id, consulta) {
    proceso = "consulta";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#grupo_semillero_rs').val(resultado.curso_grupo);
        $('#id_rs').val(resultado.id);
        $('#codigo_docente_rs').val(resultado.codigo_docente);
        $('#cantidadPersonas_rs').val(resultado.cantidad_personas);
        $('#hora_inicio_rs').val(resultado.hora_inicio + ":00");
        $('#hora_fin_rs').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_rs').val(resultado.fecha_prestamo);
        
        $('#telefono_rs').val(resultado.telefono);
        $('#correo_rs').val(resultado.correo);
        $('#departamento_rs').val(resultado.departamento);
        $('#observaciones_prestamo_rs').val(resultado.observaciones_prestamo);
        openModal('modal-responder-semillero');
    });
}

function cargarDetalleHistoricoSemillero(id, consulta) {
    proceso = "consulta";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#grupo_semillero_cs').val(resultado.curso_grupo);
        $('#id_cs').val(resultado.id);
        $('#codigo_docente_cs').val(resultado.codigo_docente);
        $('#cantidadPersonas_cs').val(resultado.cantidad_personas);
        $('#hora_inicio_cs').val(resultado.hora_inicio + ":00");
        $('#hora_fin_cs').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_cs').val(resultado.fecha_prestamo);
        $('#fecha_respuesta_cs').val(resultado.fecha_respuesta);
        var respuesta = resultado.respuesta;
        $("input[name='respuesta_cs']").each(function ()
        {
                if(respuesta==$(this).val()){
                    $(this).prop( "checked", true);
                }        
        });
        $('#telefono_cs').val(resultado.telefono);
        $('#correo_cs').val(resultado.correo);
        $('#departamento_cs').val(resultado.departamento);
        $('#observaciones_prestamo_cs').val(resultado.observaciones_prestamo);
        $('#observaciones_respuesta_cs').val(resultado.observaciones_respuesta);
        openModal('modal-consulta-semillero');
    });


}

function  responder_auditorio()
{
    observaciones=$('#observaciones_respuesta_ra').val();
    correo=$('#correo_ra').val();
    codigo=$('#codigo_docente_ra').val();
    var respuesta=null;
    $("input[name='respuesta_ra']:checked").each(function ()
    {
        respuesta = $(this).val();
    });
    if(respuesta==null){
        $msg = "error";
        alertNotification($msg);
        return ;
    }
    id=$('#id_ra').val();
    proceso = "registrar_respuesta_auditorio";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            respuesta: respuesta,
            observaciones: observaciones,
            correo:correo,
            codigo:codigo,
            id:id
        }
    }).done(function (sub) {
        if(sub=='true'){
            location.reload();
        }else{
            alertNotification();
        }
    });

}

function  responder_auditorio2()
{
    observaciones=$('#observaciones_respuesta_ca').val();
    correo=$('#correo_ca').val();
    codigo=$('#codigo_docente_ca').val();
    var respuesta=null;
    $("input[name='respuesta_ca']:checked").each(function ()
    {
        respuesta = $(this).val();
    });
    if(respuesta==null){
        $msg = "error";
        alertNotification($msg);
        return ;
    }
    id=$('#id_ca').val();
    proceso = "registrar_respuesta_auditorio";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            respuesta: respuesta,
            observaciones: observaciones,
            correo:correo,
            codigo:codigo,
            id:id
        }
    }).done(function (sub) {
        if(sub=='true'){
            location.reload();
        }else{
            alertNotification();
        }
    });

}

function prestar_semillero_modal()
{
    openModal('modal-prestamo-semillero');
}

function prestar_semillero()
{
    proceso = "registrar_prestamo_semillero";
    grupo_semillero = $("#grupo_semillero").val();
    cantidadPersonas = $("#cantidadPersonas_s").val();
    fecha_prestamo = $("#fecha_prestamo_s").val();
    hora_inicio = $('#hora_inicio_s option:selected').text();
    hora_fin = $('#hora_fin_s option:selected').text();
    telefono = $("#telefono_s").val();
    departamento = $("#departamento_s").val();
    observaciones = $("#observaciones_s").val();
    correo = $("#correo_s").val();

    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            grupo_semillero: grupo_semillero,
            cantidadPersonas: cantidadPersonas,
            fecha_prestamo: fecha_prestamo,
            hora_inicio: hora_inicio,
            hora_fin: hora_fin,
            telefono: telefono,
            departamento: departamento,
            observaciones: observaciones,
            correo: correo
        }
    }).done(function (sub) {
        confirmarSolicitudAuditorio(sub);
    });
}

function responder_semillero(){
    observaciones=$('#observaciones_respuesta_rs').val();
    correo=$('#correo_rs').val();
    codigo=$('#codigo_docente_rs').val();
    var respuesta=null;
    $("input[name='respuesta_rs']:checked").each(function ()
    {
        respuesta = $(this).val();
    });
    if(respuesta==null){
        $msg = "error";
        alertNotification($msg);
        return ;
    }
    id=$('#id_rs').val();
    proceso = "registrar_respuesta_semillero";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            respuesta: respuesta,
            observaciones: observaciones,
            correo:correo,
            codigo:codigo,
            id:id
        }
    }).done(function (sub) {
        if(sub=='true'){
            location.reload();
        }else{
            alertNotification();
        }
    });
}

function responder_semillero2(){
    observaciones=$('#observaciones_respuesta_cs').val();
    correo=$('#correo_cs').val();
    codigo=$('#codigo_docente_cs').val();
    var respuesta=null;
    $("input[name='respuesta_cs']:checked").each(function ()
    {
        respuesta = $(this).val();
    });
    if(respuesta==null){
        $msg = "error";
        alertNotification($msg);
        return ;
    }
    id=$('#id_cs').val();
    proceso = "registrar_respuesta_semillero";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso,
            respuesta: respuesta,
            observaciones: observaciones,
            correo:correo,
            codigo:codigo,
            id:id
        }
    }).done(function (sub) {
        if(sub=='true'){
            location.reload();
        }else{
            alertNotification();
        }
    });
}

function listarSolicitudesSemillero()
{
    proceso = "listar_solicitudes_semillero";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        for (var i = 0; i < resultado.length; i++) {
            resultado[i].fecha_solicitud = resultado[i].fecha_solicitud.toString().substring(0, 12);
            resultado[i].fecha_prestamo = resultado[i].fecha_prestamo.toString().substring(0, 12);
            resultado[i].hora_inicio = resultado[i].hora_inicio.toString() + ":00";
            resultado[i].hora_fin = resultado[i].hora_fin.toString() + ":00";
        }
        $('#prestamo_semillero_tabla').DataTable({
            data: resultado,
            columns: [
                {data: 'id'},
                {data: 'fecha_solicitud'},
                {data: 'curso_grupo'},
                {data: 'fecha_prestamo'},
                {data: 'hora_inicio'},
                {data: 'hora_fin'}
            ]
        });
        var pstable = $('#prestamo_semillero_tabla').DataTable();
        $('#prestamo_semillero_tabla tbody').on('click', 'tr', function () {
            var data = pstable.row(this).data();
            cargarDetalleSolicitudSemillero(data.id, "ss");
        });
    });
}

function listarPrestamosAuditorio()
{
    proceso = "listar_prestamos_auditorio";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        for (var i = 0; i < resultado.length; i++) {
            resultado[i].fecha_solicitud = resultado[i].fecha_solicitud.toString().substring(0, 12);
            resultado[i].fecha_prestamo = resultado[i].fecha_prestamo.toString().substring(0, 12);
            resultado[i].fecha_respuesta = resultado[i].fecha_prestamo.toString().substring(0, 12);
            resultado[i].hora_inicio = resultado[i].hora_inicio.toString() + ":00";
            resultado[i].hora_fin = resultado[i].hora_fin.toString() + ":00";
        }
        $('#auditorio_historico_tabla').DataTable({
            data: resultado,
            columns: [
                {data: 'id'},
                {data: 'fecha_solicitud'},
                {data: 'titulo'},
                {data: 'fecha_prestamo'},
                {data: 'hora_inicio'},
                {data: 'hora_fin'},
                {data: 'respuesta'},
                {data: 'fecha_respuesta'}
            ]
        });
        var hatable = $('#auditorio_historico_tabla').DataTable();
        $('#auditorio_historico_tabla tbody').on('click', 'tr', function () {
            var data = hatable.row(this).data();
            cargarDetalleHistoricoAuditorio(data.id, "pa");
        });
    });
}

function listarPrestamosSemillero()
{
    proceso = "listar_prestamos_semillero";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        for (var i = 0; i < resultado.length; i++) {
            resultado[i].fecha_solicitud = resultado[i].fecha_solicitud.toString().substring(0, 12);
            resultado[i].fecha_prestamo = resultado[i].fecha_prestamo.toString().substring(0, 12);
            resultado[i].fecha_respuesta = resultado[i].fecha_prestamo.toString().substring(0, 12);
            resultado[i].hora_inicio = resultado[i].hora_inicio.toString() + ":00";
            resultado[i].hora_fin = resultado[i].hora_fin.toString() + ":00";
        }
        $('#semillero_historicos_tabla').DataTable({
            data: resultado,
            columns: [
                {data: 'id'},
                {data: 'fecha_solicitud'},
                {data: 'curso_grupo'},
                {data: 'fecha_prestamo'},
                {data: 'hora_inicio'},
                {data: 'hora_fin'},
                {data: 'respuesta'},
                {data: 'fecha_respuesta'}
            ]
        });
        
        var table = $('#semillero_historicos_tabla').DataTable();        

        $('#semillero_historicos_tabla tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            cargarDetalleHistoricoSemillero(data.id, "ps");
        });
    });
}

//****************** ALERTA NOTIFICACIÓN****************************//

(function(){
    proceso = "listar_solicitudes_auditorio";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        var count = (JSON.parse(sub)).length;
        var badge = document.getElementById('badgeAudi');
        window.setInterval(function(){
            if(count!=0){
                updateBadge(count);
            }
        }, 2000); //Update the badge ever 5 seconds
        var badgeNum;
        function updateBadge(alertNum){//To rerun the animation the element must be re-added back to the DOM
            var badgeChild = badge.children[0];
            if(badgeChild.className==='badge-num'){
                badge.removeChild(badge.children[0]);
            }
            badgeNum = document.createElement('div');
            badgeNum.setAttribute('class','badge-num');
            badgeNum.innerText = alertNum;
            badge.insertBefore(badgeNum,badge.firstChild);
        }
    });
})(document);


(function(){
    proceso = "listar_solicitudes_semillero";
    $.ajax({
        url: 'negocio/procesar/ProcesarAdministrador.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        var count = (JSON.parse(sub)).length;
        var badge = document.getElementById('badgeSemi');
        window.setInterval(function(){
            if(count!=0){
                updateBadge(count);
            }
        }, 2000); //Update the badge ever 5 seconds
        var badgeNum;
        function updateBadge(alertNum) {//To rerun the animation the element must be re-added back to the DOM
            var badgeChild = badge.children[0];
            if (badgeChild.className == 'badge-num'){
                badge.removeChild(badge.children[0]);
            }
            badgeNum = document.createElement('div');
            badgeNum.setAttribute('class','badge-num');
            badgeNum.innerText = alertNum;
            badge.insertBefore(badgeNum,badge.firstChild);
        }
    });
})(document);
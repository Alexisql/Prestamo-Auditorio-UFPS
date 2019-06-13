/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//auditorio

cargarTablas();


function cargarTablas()
{
    $(document).ready(function () {
        listarSolicitudesDocente();
        listarPrestamosDocente();
        listarSolicitudesDocenteS();
        listarPrestamosDocenteS();
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


function listarSolicitudesDocente()
{
    proceso = "listar_solicitudes_auditorio_docente";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
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

    proceso = "consultar_dato";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#titulo_sa').val(resultado.titulo);
        $('#id_sa').val(resultado.id);
        $('#cantidadPersonas_sa').val(resultado.cantidad_personas);
        $('#hora_inicio_sa').val(resultado.hora_inicio + ":00");
        $('#hora_fin_sa').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_sa').val(resultado.fecha_prestamo.toString().substring(0, 12));
        $('#fecha_solicitud_sa').val(resultado.fecha_solicitud.toString().substring(0, 12));
        var objetos = resultado.objetos.toString().split(':');
        $("input[name='objeto_sa']").each(function ()
        {
            for (var i = 0; i < objetos.length; i++) {
                if (objetos[i] == $(this).val()) {
                    $(this).prop("checked", true);
                }
            }
        });
        $('#telefono_sa').val(resultado.telefono);
        $('#correo_sa').val(resultado.correo);
        $('#departamento_sa').val(resultado.departamento);
        $('#observaciones_sa').val(resultado.observaciones_prestamo);
        openModal('modal-prestamo-aditorio-detalle');
    });
}

function cancelarSolicitudA() {

    proceso = "cancelar_auditorio";
    id=$('#id_sa').val();
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
        }
    }).done(function (sub) {
        if(sub=="true"){
            location.reload();
        }else{
            cancelarSolicitudAuditorio();
        }
    });
}
function cancelarSolicitudS() {

    proceso = "cancelar_semillero";
    id=$('#id_ss').val();
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
        }
    }).done(function (sub) {
        if(sub=="true"){
            location.reload();
        }else{
            cancelarSolicitudAuditorio();
        }
    });
}

function listarSolicitudesDocenteS()
{
    proceso = "listar_solicitudes_semilleros_docente";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
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
        var patable = $('#prestamo_semillero_tabla').DataTable();

        $('#prestamo_semillero_tabla tbody').on('click', 'tr', function () {
            var data = patable.row(this).data();
            cargarDetalleSolicitudSemillero(data.id, "ss");
        });
        //$("#programas").html(sub);
        //$("#programas").show();
    });
}

function cargarDetalleSolicitudSemillero(id, consulta)
{
    proceso = "consultar_dato";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#grupo_semillero_ss').val(resultado.curso_grupo);
        $('#id_ss').val(resultado.id);
        $('#cantidadPersonas_ss').val(resultado.cantidad_personas);
        $('#hora_inicio_ss').val(resultado.hora_inicio + ":00");
        $('#hora_fin_ss').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_ss').val(resultado.fecha_prestamo);
        $('#fecha_solicitud_ss').val(resultado.fecha_solicitud);
        $('#telefono_ss').val(resultado.telefono);
        $('#correo_ss').val(resultado.correo);
        $('#departamento_ss').val(resultado.departamento);
        $('#observaciones_ss').val(resultado.observaciones_prestamo);
        openModal('modal-prestamo-semillero-datalle');
    });
}

function listarPrestamosDocente()
{
    proceso = "listar_prestamos_auditorio_docente";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
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
        var patable = $('#auditorio_historico_tabla').DataTable();
        $('#auditorio_historico_tabla tbody').on('click', 'tr', function () {
            var data = patable.row(this).data();
            cargarDetallePrestamoAuditorio(data.id, "pa");
        });
        //$("#programas").html(sub);
        //$("#programas").show();
    });
}

function cargarDetallePrestamoAuditorio(id, consulta)
{
    proceso = "consultar_dato";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#titulo_pa').val(resultado.titulo);
        $('#id_pa').val(resultado.id);
        $('#cantidadPersonas_pa').val(resultado.cantidad_personas);
        $('#hora_inicio_pa').val(resultado.hora_inicio + ":00");
        $('#hora_fin_pa').val(resultado.hora_fin + ":00");
        $('#fecha_prestamo_pa').val(resultado.fecha_prestamo);
        $('#fecha_respuesta_pa').val(resultado.fecha_respuesta);
        $('#fecha_solicitud_pa').val(resultado.fecha_solicitud);
        var objetos = resultado.objetos.toString().split(':');
        $("input[name='objeto_pa']").each(function ()
        {
            for (var i = 0; i < objetos.length; i++) {
                if (objetos[i] == $(this).val()) {
                    $(this).prop("checked", true);
                }
            }
        });
        $('#telefono_pa').val(resultado.telefono);
        $('#correo_pa').val(resultado.correo);
        $('#departamento_pa').val(resultado.departamento);
        $('#respuesta_pa').val(resultado.respuesta);
        $('#observaciones_prestamo_pa').val(resultado.observaciones_prestamo);
        $('#observaciones_respuesta_pa').val(resultado.observaciones_respuesta);
        openModal('modal-historico-aditorio-detalle');
    });

}
function listarPrestamosDocenteS()
{
    proceso = "listar_prestamos_semilleros_docente";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
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
        var patable = $('#semillero_historicos_tabla').DataTable();

        $('#semillero_historicos_tabla tbody').on('click', 'tr', function () {
            var data = patable.row(this).data();
            cargarDetallePrestamoSemillero(data.id, "ps");
        });
        //$("#programas").html(sub);
        //$("#programas").show();
    });
}

function cargarDetallePrestamoSemillero(id, consulta){
    proceso = "consultar_dato";
    $.ajax({
        url: 'negocio/procesar/ProcesarDocente.php',
        type: 'POST',
        data: {
            proceso: proceso,
            id: id,
            consulta: consulta
        }
    }).done(function (sub) {
        var resultado = JSON.parse(sub);
        $('#grupo_semillero_ps').val(resultado.curso_grupo);
        $('#id_ps').val(resultado.id);
        $('#cantidadPersonas_ps').val(resultado.cantidad_personas);
        $('#hora_inicio_ps').val(resultado.hora_inicio + ":00");
        $('#hora_fin_ps').val(resultado.hora_fin + ":00");
        $('#fecha_respuesta_ps').val(resultado.fecha_respuesta);
        $('#fecha_prestamo_ps').val(resultado.fecha_prestamo);
        $('#fecha_solicitud_ps').val(resultado.fecha_solicitud);
        $('#telefono_ps').val(resultado.telefono);
        $('#correo_ps').val(resultado.correo);
        $('#departamento_ps').val(resultado.departamento);
        $('#respuesta_ps').val(resultado.respuesta);
        $('#observaciones_prestamo_ps').val(resultado.observaciones_prestamo);
        $('#observaciones_respuesta_ps').val(resultado.observaciones_respuesta);
        openModal('modal-historico-semillero-datalle');
    });
    
}
//semillero
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
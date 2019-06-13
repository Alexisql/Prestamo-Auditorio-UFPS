
function IniciarSesion() {

    codigo = $("#codigo").val();
    pass = $("#password").val();
    proceso = "iniciarSesion";

    $.ajax({
        url: 'negocio/procesar/procesar.php',
        type: 'POST',
        data: {
            codigo: codigo,
            pass: pass,
            proceso: proceso
        }
    }).done(function (sub) {
        if(sub.indexOf('false')>=0){
            alertErrorLogIn();
        }else{
            alertLogIn(sub);
        }
    });
}

function autenticar(){
    proceso = "validarSesion";    
    $.ajax({
        url: 'negocio/procesar/procesar.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        if ((sub.indexOf('false') >= 0)) {
            location.href = "index.html";
        }else if(sub.indexOf('docente') >= 0){
            location.href = "docente.html";
        }
    });
}

function autenticarDocente(){
    proceso = "validarSesion";    
    $.ajax({
        url: 'negocio/procesar/procesar.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        if ((sub.indexOf('false') >= 0)) {
            location.href = "index.html";
        }else if(sub.indexOf('admin') >= 0){
            location.href = "administrador.html";
        }
    });
}

function  cerrarSesion(){
    proceso = "cerrar";    
    $.ajax({
        url: 'negocio/procesar/procesar.php',
        type: 'POST',
        data: {
            proceso: proceso
        }
    }).done(function (sub) {
        alertClosedSession(sub);
    });
}

window.onload = function () {
    toggleAccordion();
    closeAlertListener();
}





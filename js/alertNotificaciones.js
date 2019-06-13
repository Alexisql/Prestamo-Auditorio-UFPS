function alertClosedSession(msg) {
    swal ({
        title: msg,
        text:" ",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
        icon: "success"
    });
    setTimeout ( " location.href = \'index.html\'" , 1000 );
}

function alertLogIn(msg) {
    if(msg==='administrador') {
        swal({
            title: "¡¡Bienvenido Administrador!!",
            text: " ",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "success"
        });
        setTimeout ( " location.href = '\administrador.html\'" , 1000 );
    }else{
        swal({
            title: "¡¡Bienvenido!!",
            text: " ",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "success"
        });
        setTimeout ( " location.href = '\docente.html\'" , 1000 );
    }

}

function alertErrorLogIn() {
    swal ({
        title: "¡¡Error!!",
        text:"Su contraseña y/o usuario son incorrectos",
        button: true,
        icon: "error"
    });
    setTimeout ( " location.href = '\index.html\'" , 2000 );
}

//*********ALERTAS PARA AUDITORIOS************//

function confirmarSolicitudAuditorio(msg) {
    if (msg.indexOf("true") >= 0){
        swal ({
            title: "!!Solicitud Registrada!!",
            text: " ",
            button: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "success"
        });
        setTimeout ( " location.href = \'docente.html\'" , 1000 );
    } else if (msg == "false"){
        swal ({
            title: "Respuesta",
            text: "Hay un error en la base de datos, por favor intentelo más tarde",
            button: true,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "error"
        });
        setTimeout ( " location.href = \'docente.html\'" , 4000 );

    }else {
        swal ({
            title: "Respuesta",
            text: msg,
            button: true,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "error"
        });
    }
}

function cancelarSolicitudAuditorio() {
    swal ({
        title:"Solicitud Cancelada",
        text:" ",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false,
        icon: "success"
    });
    setTimeout ( " location.href = \'docente.html\'" , 1000 );
}

function alertNotification(msg){

    if(msg=="error"){
        swal ({
            title: "Respuesta",
            text: "Debe aprobar o rechazar la solicitud",
            button: true,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "error"
        });
    }else{
        swal ({
            title: "¡¡LISTO!!",
            text: " ",
            buttons: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
            icon: "success"
        });
        setTimeout ( " location.href = \'administrador.html\'" , 1000 );
    }
}
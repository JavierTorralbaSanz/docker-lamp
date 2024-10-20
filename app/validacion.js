

function DNIcorrecto(dni)
{
    //Funcion que se usa para verificar si la lera del DNI es correcta
    //Se puede saber si la letra del DNI es correcta segun los numeros del DNI
    var numeroDNI=dni.substring(0,8);
    numeroDNI=parseInt(numeroDNI)%23;
    let dic={
        0:"T", 1:"R",2:"w",
        3:"A",4:"G",5:"M",
        6:"Y",7:"F",8:"p",
        9:"D",10:"X",11:"B",
        12:"N",13:"J",14:"Z",
        15:"S",16:"Q",17:"V",
        18:"H",19:"L",20:"C",
        21:"K",22:"E"
     
    };
    return dni[9]==dic[numeroDNI];
}

function validar_dni(dni) {
    //Comprobar letra DNI correcta y que el formato es correcto, mediante una expresión regular
    if( !(dni.length==10 && /^[0-9]{8}-[A-Z]$/.test(dni) && DNIcorrecto(dni)))
    {
        return false;   
    }
    return true;
}

function validar_nombre(nombre) {
    //Un nombre solo podra ser valido si esta compuesto por valores aalfabeticos
    if (!/^[a-zA-Z\s]+$/.test(nombre))
    {
        return false;
    }
    return true;
}

function validar_telefono(telefono) {
    //Compruena ¡un numero de telefono solamente valdran los numeros de telefono de 9 digitos
    if(!(telefono.length==9 && /^[0-9]{9}$/.test(telefono)))
    {
        return false;
    }
    return true;
}

function validar_fecha(fecha) {
    //Fecha de Nacimiento en formato de AA-YY-DD, un ejemplo: 1999-08-26
    //!isNaN(Date.parse(fecha)) en este comando se comprueba si la fecha introducida es correcta
    if(!( /^\d{4}-\d{2}-\d{2}$/.test(fecha) && !isNaN(Date.parse(fecha))))
    {
        return false;
    }
    return true;
}

function validar_email(email) {
    //Solo formatos de email validos ejemplo@servidor.extension
    if (!(/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)$/.test(email)))
    {
        return false;
    }
    return true;
}

function validar_passwords(c1, c2) {
    //Se comprueba si es el mismo password o sino se ha introducido nada para mantener o modificar el password
    if (c1 != c2) {
        return false;
    }

    if (c1.length == 0) {
        return false;
    }
    return true;
}

function validar_username(username) {
    //Se comprueba si no se ha introducido ningun username
    //Si no ha sido introducido ninguno el username se mantiene igual y si ha sido introducido un username este se cambia.
    if (username.length == 0) {
        return false;
    }
    return true;
}

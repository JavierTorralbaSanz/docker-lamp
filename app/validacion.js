function DNIcorrecto(dni)
{
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
    if (!/^[a-zA-Z\s]+$/.test(nombre))
    {
        return false;
    }
    return true;
}

function validar_telefono(telefono) {
    //Comprobar digito de telefono solo 9 digitos.
    if(!(telefono.length==9 && /^[0-9]{9}$/.test(telefono)))
    {
        return false;
    }
    return true;
}

function validar_fecha(fecha) {
    //Fecha de Nacimiento en formato de 1999-08-26
    if(!( /^\d{4}-\d{2}-\d{2}$/.test(fecha) && !isNaN(Date.parse(fecha))))
    {
        return false;
    }
    return true;
}

function validar_email(email) {
    //Solo formatos de email validos ejemplo@servidor.extension
    if (!(/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@gmail\.com$/.test(email)))
    {
        return false;
    }
    return true;
}

function validar_passwords(c1, c2) {
    if (c1 != c2) {
        return false;
    }

    if (c1.length == 0) {
        return false;
    }
    return true;
}

function validar_username(username) {
    if (username.length == 0) {
        return false;
    }
    return true;
}

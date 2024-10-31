<?php


const numero_dni = "TRWAGMYFPDXBNJZSQVHLCKE";


function validar_dni(string $dni) : boolean {
    // Estructura del DNI: 00000000-T
    $regex = "/^[0-9]{8}-[A-Z]$/";

    if (preg_match($regex, $dni) != 1) {
        return false;
    }

    $numero = (int) substr($dni, 0, 8);
    $letra = substr($dni, 9);
    return $numero_dni[$numero % 23] == $letra;
}

function validar_nombre(string $nombre) : boolean {
    $regex = "/^[a-zA-Z]+$/";
    return preg_match($regex, $nombre) == 1;
}


function validar_telefono(string $telf) : boolean {
    $regex = "/^[0-9]{9}$/";
    return strlen($telf) == 9 && preg_match($regex, $telf) == 1;
}

function validar_fecha(string $fecha) : boolean {
    $regex = "/^\d{4}-\d{2}-\d{2}$/";
    if (preg_match($regex, $fecha) != 1) {
        return false;
    }

    $arr = explode('-', $fecha);
    // Checkdate espera una fecha en formato mm-dd-yyyy
    return checkdate($arr[1], $arr[2], $arr[0]);
}

function validar_email(string $email) : boolean {
    $regex = "/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)$/";
    return preg_match($regex, $email);
}

function validar_passwords(string $c1, string $c2) {
    if ($c1 !== $c2) {
        return false;
    }

    if (count($c1) == 0) {
        return false;
    }

    // Requisitos mínimos en la contraseña
}

function validar_username(string $username) {
    return strlen($username) > 0;
}

?>

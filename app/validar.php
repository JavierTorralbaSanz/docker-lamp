<?php


function validar_dni(string $dni) {
    // Estructura del DNI: 00000000-T
    $regex = "/^[0-9]{8}-[A-Z]$/";

    if (preg_match($regex, $dni) != 1) {
        return false;
    }

    $numero_dni = "TRWAGMYFPDXBNJZSQVHLCKE";
    $numero = (int) substr($dni, 0, 8);
    $letra = substr($dni, 9);
    return $numero_dni[$numero % 23] == $letra;
}

function validar_nombre(string $nombre) {
    $regex = "/^[a-zA-Z]+(\ [a-zA-Z]+)*$/";
    return preg_match($regex, $nombre) == 1;
}


function validar_telefono(string $telf) {
    $regex = "/^[0-9]{9}$/";
    return strlen($telf) == 9 && preg_match($regex, $telf) == 1;
}

function validar_fecha(string $fecha) {
    $regex = "/^\d{4}-\d{2}-\d{2}$/";
    if (preg_match($regex, $fecha) != 1) {
        return false;
    }

    $arr = explode('-', $fecha);
    // Checkdate espera una fecha en formato mm-dd-yyyy
    return checkdate($arr[1], $arr[2], $arr[0]);
}

function validar_email(string $email) {
    $regex = "/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)$/";
    return preg_match($regex, $email);
}

function validar_passwords(string $c1, string $c2) {
    if ($c1 != $c2) {
        return false;
    }

    if (strlen($c1) == 0) {
        return false;
    }

    // Requisitos mínimos en la contraseña
    return true;
}
function verificar_password($password) {
    // Definimos los criterios
    $criterios = [
        'longitud' => strlen($password) >= 6,
        'mayuscula' => preg_match('/[A-Z]/', $password),
        'minuscula' => preg_match('/[a-z]/', $password),
        'numero' => preg_match('/[0-9]/', $password),
        'especial' => preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)
    ];

    // Comprobamos si cumple todos los criterios
    $cumpleTodos = array_reduce($criterios, function($carry, $criterio) {
        return $carry && $criterio;
    }, true);

    return $cumpleTodos;
}

function validar_username(string $username) {
    return strlen($username) > 0;
}

?>

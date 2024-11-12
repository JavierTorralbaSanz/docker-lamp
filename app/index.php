<?php

session_start([
    'cookie_samesite' => 'Strict', //se puede poner Lax segun lo que necesitemos
    'cookie_secure' => true,        //Asegura que la cookie solo se envie por HTTPS
    'cookie_httponly' => true       //Evita que la cookie sea accesible desde JavaScript
]);
    //Este archivo se encargará de gestionar el redireccionamiento a otras partes de la página
    switch (explode("?", $_SERVER['REQUEST_URI'])[0]) {
        case '/':
            //Zona inicial usuario no indentificado
            if (!isset($_SESSION['usuario'])) {
                    echo '<head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Opciones de la Página</title>
                        <link rel="stylesheet" href="estilos.css">
                    </head>
                    <body>
                        <div class="container">
                            
                               <a href="/register" class="link-button">Registrarse</a><br>
                               <a href="/login" class="link-button">Login</a><br>
                               <a href="/add_item" class="link-button">Añadir juego</a><br>
                               <a href="/items" class="link-button">Ver lista videojuegos</a><br>
                        </div>
                    </body>';
            
            }
            else {
                //Usuario ha sido indentificado
                echo '<head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Opciones de la Página</title>
                        <link rel="stylesheet" href="estilos.css">
                        <script src="inactividad.js"></script>
                    </head>';
                    echo '<body>
                        <div class="container">
                            
                               <a href="/show_user?user=' . $_SESSION['usuario'] . '" class="link-button" >Info usuario</a><br>
                               <a href="/logout" class="link-button">Cerrar sesión</a><br>
                               <a href="/add_item" class="link-button">Añadir juego</a><br>
                               <a href="/items" class="link-button">Ver lista videojuegos</a><br>
                        <div>
                    </body>';
                
            }
            
            break;


        case '/register':
            require 'register.php';
            break;

        case '/login':
            require 'login.php';
            break;
        
        case '/show_user':
            require 'show_user.php';
            break;
        
        case '/modify_user':
            require 'modify_user.php';
            break;
        
        case '/logout':
            unset($_SESSION['usuario']);
            header('Location: /');
            break;

        case '/add_item':
            require 'annadir_juego.php';
            break;

        case '/items':
            require 'items.php';
            break;
        
        case '/show_item':
            require 'show_juego.php';
            break;
	    case '/delete_item':
            require 'eliminar_juego.php';
            break;
        case '/modify_item':
            require 'modify_item.php';
            break;
        default:
            echo '404 not found';
    }
?>

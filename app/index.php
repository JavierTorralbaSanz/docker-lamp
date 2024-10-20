<?php

    session_start();

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
                    </head>
                    <body>
                        <div class="container">
                            
                               <a href="/show_user?user=' . $_SESSION['usuario'] . '" class="link-button" >Info usuario</a><br>
                               <a href="/logout" class="link-button">Cerrar sesión</a><br>
                        <div>
                    </body>';
                
            }
            
            // phpinfo();
            $hostname = "db";
            $username = "admin";
            $password = "test";
            $db = "database";

            $conn = mysqli_connect($hostname,$username,$password,$db);
            if ($conn->connect_error) {
                die("Database connection failed: " . $conn->connect_error);
            }

            //Se imprime el id y el nombre de los usuarios registrados
            $query = mysqli_query($conn, "SELECT * FROM usuarios")
                or die (mysqli_error($conn));

            while ($row = mysqli_fetch_array($query)) {
                echo
                    "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nombre']}</td>
                    </tr>";
            }
            break;


        case '/register':
            require 'register.html';
            break;

        case '/login':
            require 'login.html';
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

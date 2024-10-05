<?php

    session_start();

    switch (explode("?", $_SERVER['REQUEST_URI'])[0]) {
        case '/':
            if (!isset($_SESSION['usuario'])) {
                echo '<a href="/register">Registrarse</a><br>';
                echo '<a href="/login">Login</a><br>';
                echo '<a href="/add_item">Añadir juego</a><br>';
                echo '<a href="/items">Ver lista videojuegos</a><br>';
            }
            else {
                echo '<a href="/show_user?user=' . $_SESSION['usuario'] . '">Info usuario</a><br>';
                echo '<a href="/logout">Cerrar sesión</a><br>';
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

        default:
            echo '404 not found';
    }
?>

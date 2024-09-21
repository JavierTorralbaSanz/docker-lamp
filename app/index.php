<?php
    switch ($_SERVER['REQUEST_URI']) {
        case '/register':
            require 'register.html';
            break;

        case '/':
            echo '<h1>Yeah, it works!</h1>';
            echo '<a href="/register">Registrarse</a><br>';
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

        default:
            echo '404 not found';
    }
?>

<?php

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        parse_str($_SERVER['QUERY_STRING'], $params);

        if (!$params) {
            echo 'No se ha especificado un DNI<br>';
            echo '<a href="/">Página inicial</a>';
            return;
        }

        $usuario = $params['user'];

        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $conn = mysqli_connect($hostname,$username,$password,$db);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $query = mysqli_query($conn, "SELECT * FROM usuarios WHERE username = '$usuario'")
            or die (mysqli_error($conn));

        $row = mysqli_fetch_array($query);

        if ($row) {

            echo "
            <script src='validacion.js'> </script>
            <script>
                function validar_datos() {
                    var nombre = document.getElementById('nombre').value;
                    var dni = document.getElementById('dni').value;
                    var telefono = document.getElementById('telefono').value;
                    var fecha = document.getElementById('fecha').value;
                    var email = document.getElementById('email').value;
                    var c1 = document.getElementById('password1').value;
                    var c2 = document.getElementById('password2').value;
                    
                    if (!validar_nombre(nombre)) {
                        alert('Nombre de usuario inválido');
                        return;
                    }
                    if (!validar_dni(dni)) {
                        alert('DNI inválido. Formato: 12345678-A');
                        return;
                    }
                    if (!validar_telefono(telefono)) {
                        alert('Teléfono inválido. Formato: 123456789');
                        return;
                    }
                    if (!validar_fecha(fecha)) {
                        alert('Fecha inválida. Formato: yyyy-mm-dd');
                        return;
                    }
                    if (!validar_email(email)) {
                        alert('Email inválido');
                        return;
                    }

                    if (c1.length > 0) {
                        if (!validar_passwords(c1, c2)) {
                            alert('Contraseña inválida. Las contraseñas deben coincidir y no ser nulas');
                            return;
                        }
                    }

                    // todo ok
                    document.user_modify_form.submit();
                }
            </script>

            <form name='user_modify_form' id='user_modify_form' action='modify_user.php?user={$usuario}' method='POST'>
                <label for='name'>Nombre y apellidos:</label><br>
                <input type='text' id='nombre' name='nombre' value={$row['nombre']}><br>
                <label for='name'>DNI:</label><br>
                <input type='text' id='dni' name='dni' value={$row['dni']}><br>
                <label for='name'>Teléfono:</label><br>
                <input type='text' id='telefono' name='telefono' value={$row['telefono']}><br>
                <label for='name'>Fecha de nacimiento:</label><br>
                <input type='text' id='fecha' name='fecha' value={$row['fecha']}><br>
                <label for='name'>Email:</label><br>
                <input type='text' id='email' name='email' value={$row['email']}><br>
                <label id='c1'>Contraseña (vacía si no quiere cambiarla):</label><br>
                <input type='password' id='password1' name='password1'><br>
                <label id='c2'>Repetir contraseña:</label><br>
                <input type='password' id='password2' name='password2'><br>
                <input type='button' value='Submit' id='user_modify_submit' onclick='validar_datos()'>
            </form>";
        }
    }

    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
        $fecha = $_POST['fecha'];
        $email = $_POST['email'];
        parse_str($_SERVER['QUERY_STRING'], $params);
        $usuario = $params['user'];

        $c1 = $_POST['password1'];
        $c2 = $_POST['password2'];

        // query
        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $conn = mysqli_connect($hostname,$username,$password,$db);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        $query = mysqli_query($conn,
            "UPDATE usuarios SET nombre = '$usuario', dni = '$dni', telefono='$telefono',
            fecha = '$fecha', email = '$email'
            WHERE username = '$usuario'
        ")
            or die (mysqli_error($conn));

        
        if (strlen($c1) > 0) {
            $query = mysqli_query($conn, "UPDATE usuarios SET contraseña = '$c1' WHERE username = '$usuario'") or die (mysqli_error($conn));
        }

        echo 'Datos actualizados<br>';
        echo '<a href="/">Página principal</a>';

    }

?>
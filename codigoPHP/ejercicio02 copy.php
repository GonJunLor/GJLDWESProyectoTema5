<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/11/2025
* 2. Desarrollo de un control de acceso con identificación del usuario basado en la función header() 
* y en el uso de una tabla “Usuario” de la base de datos. (PDO).
*/
// importamos el archivo con los datos de conexión
require_once '../conf/confDBPDO.php';

// codificamos la contraseña para guardarla en la bbdd
// $codificarContraseña = password_hash("adminpaso",PASSWORD_DEFAULT);

$comporobar = password_verify('adminpaso','$2y$10$AZurnSfl5Z/bqMVixkrV1uUUt4sbGXxfdtz3JAJBok1qKd.0rZ1la');

// Variable para comprobar si el usuario es válido
$usuarioValido = false;

// Si el usuario aún no se ha autentificado, pedimos las credenciales
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    // Enviar encabezado de autenticación para solicitar credenciales
    header('WWW-Authenticate: Basic realm="Contenido restringido"');
    header('HTTP/1.0 401 Unauthorized');

    // Mostrar mensaje si damos a cancelar
    echo '<h1>Acceso denegado. Se requiere autenticación.</h1>';
    exit;

} else { // Si ya ha enviado las credenciales, las comprobamos con la base de datos
    
    try {
        // Conectamos a la base de datos
        $miDB = new PDO(DSN,USERNAME,PASSWORD);

        // Guardamos los datos del usuario
        $usuarioRecibido = $_SERVER['PHP_AUTH_USER'];
        $contrasenaRecibida = $_SERVER['PHP_AUTH_PW'];
        $usuarioContrasena = $usuarioRecibido.$contrasenaRecibida;

        /**
         * cifrado: Nombre del algoritmo de hachado seleccionado (por ejemplo: "sha256"). Para una 
         *          lista de los algoritmos soportados ver hash_algos().
         * datos: Mensaje a cifrar.
         * binary: Cuando vale true, la salida será datos binarios sin tratar. Cuando vale false, 
         *         la salida será dígitos hexadecimales en minúscula.
         */
        $contrasenaCodificada = hash("sha256",$usuarioContrasena,false);
        // codificamos la contraseña con sha256 para compararla con la bbdd

        // Consulta preparada: Busca un usuario y contraseña coincidentes
        $sql = "SELECT nombre FROM Usuario WHERE nombre = :usuario AND contrasena = :contras";
        $consulta = $miDB->prepare($sql);
        
        // Bindea los parámetros de autenticación recibidos
        $consulta->bindParam(':usuario', $usuarioRecibido);
        $consulta->bindParam(':contras', $contrasenaCodificada);
        $consulta->execute();
        
        // Si encuentra una fila, las credenciales son correctas
        $resultado = $consulta->rowCount();
        if ($resultado == 1) {
            $usuarioValido = true;
        }

        // *********************************************************
        // Otra forma de hacer la comprobación pero con las funciones password_hash y password_verify
        // *********************************************************
        // password_hash tiene la particularidad de que crea resumen distintos para la misma contraseña cada vez que 
        // se ejecuta, aun así password_verify sabe que es correcta.
        /* 
        $sql = "SELECT contrasena FROM Usuario WHERE nombre = :usuario"; 
        $consulta = $miDB->prepare($sql);
        $consulta->bindParam(':usuario', $usuarioRecibido);
        $consulta->execute();
        $hashAlmacenado = $consulta->fetchColumn(); 

        if ($hashAlmacenado && password_verify($usuarioContrasena, $hashAlmacenado)) {
            $autenticado = true; // ¡Credenciales correctas!
        }
        */
    } catch (PDOException $miExceptionPDO) {
        // temporalmente ponemos estos errores para que se muestren en pantalla
        $aErrores['CodDepartamentoGuardar']= 'Error: '.$miExceptionPDO->getMessage().'con código de error: '.$miExceptionPDO->getCode();
    } finally {
        unset($miDB);
    }   

    if (!$usuarioValido) {
        // Enviar encabezado de autenticación para solicitar credenciales
        header('WWW-Authenticate: Basic realm="Contenido restringido"');
        header('HTTP/1.0 401 Unauthorized');
        
        // Mostrar mensaje si damos a cancelar
        echo '<h1>Acceso denegado. Se requiere autenticación.</h1>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<body>
    <div id="aviso">CURSO 2025/2026 -- DAW 2 -- I.E.S. LOS SAUCES</div>
    <nav>
        <div><a href="../indexProyectoTema5.php">Volver</a></div>
        <h2> <a href="../indexProyectoTema5.php">Tema 5</a> - Ejercicio 02</h2>
        <h2>Gonzalo Junquera Lorenzo</h2>
    </nav>
    <main>
       <h2>Acceso correcto desde la base de datos</h2>
        <p>
            Has accedido como: <strong><?php echo $_SERVER['PHP_AUTH_USER']; ?></strong>
        </p>
        <p>
            Con la contraseña: <strong><?php echo $_SERVER['PHP_AUTH_PW']; ?></strong>
        </p>
    </main>  
</body>
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../webroot/media/favicon/favicon-32x32.png">
    <link rel="stylesheet" href="../webroot/css/estilos.css">
    <title>Gonzalo Junquera Lorenzo</title>
    
</head>
</html>
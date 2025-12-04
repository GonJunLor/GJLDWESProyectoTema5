<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/11/2025
* 1. Desarrollo de un control de acceso con identificación del usuario basado en la función header().
*/

// Verificar si se han enviado credenciales con isset. Y si son correctas
if (!isset($_SERVER['PHP_AUTH_USER']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' || 
    $_SERVER['PHP_AUTH_PW'] != 'paso'){
    // Enviar encabezado de autenticación para solicitar credenciales
    header('WWW-Authenticate: Basic realm="Contenido restringido"');

    header('HTTP/1.0 401 Unauthorized');
    
    // Mostrar mensaje si damos a cancelar
    echo '<h1>Acceso denegado. Se requiere autenticación.</h1>';
    exit;
} 

// Si llega aquí, la autenticación fue exitosa.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../webroot/media/favicon/favicon-32x32.png">
    <link rel="stylesheet" href="../webroot/css/estilos.css">
    <title>Gonzalo Junquera Lorenzo</title>
</head>
<body>
    <div id="aviso">CURSO 2025/2026 -- DAW 2 -- I.E.S. LOS SAUCES</div>
    <nav>
        <div><a href="../indexProyectoTema5.php">Volver</a></div>
        <h2> <a href="../indexProyectoTema5.php">Tema 5</a> - Ejercicio 01</h2>
        <h2>Gonzalo Junquera Lorenzo</h2>
    </nav>
    <main>
        <h2>Acceso correcto</h2>
        <p>
            Has accedido como: <strong><?php echo $_SERVER['PHP_AUTH_USER']; ?></strong>
        </p>
        <p>
            Con la contraseña: <strong><?php echo $_SERVER['PHP_AUTH_PW']; ?></strong>
        </p>
    </main>
</body>
</html>
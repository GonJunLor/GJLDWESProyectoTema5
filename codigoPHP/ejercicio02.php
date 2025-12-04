<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 16/11/2025
* 2. Desarrollo de un control de acceso con identificación del usuario basado en la función header() 
* y en el uso de una tabla “Usuario” de la base de datos. (PDO).
*/
// importamos el archivo con los datos de conexión
require_once '../conf/confDBPDO.php';

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
        $usuarioPassword = $_SERVER['PHP_AUTH_USER'].$_SERVER['PHP_AUTH_PW'];

        // Conectamos a la base de datos
        $miDB = new PDO(DSN,USERNAME,PASSWORD);

        // Consulta preparada: Busca un usuario y contraseña coincidentes
        $sql = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario = :usuario AND T01_Password = sha2(:contras,256)";
        $consulta = $miDB->prepare($sql);
        $consulta->execute([
            ':usuario' => $_SERVER['PHP_AUTH_USER'],
            ':contras' => $usuarioPassword
        ]);
        
        // Si encuentra una fila, las credenciales son correctas
        $resultado = $consulta->rowCount();
        if ($resultado == 1) {
            $usuarioValido = true;
        }

    } catch (PDOException $miExceptionPDO) {
        // temporalmente ponemos estos errores para que se muestren en pantalla
        echo 'Error: '.$miExceptionPDO->getMessage().'con código de error: '.$miExceptionPDO->getCode();
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
</html>
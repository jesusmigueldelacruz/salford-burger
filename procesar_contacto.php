<?php
// Configurar zona horaria UTC-5 (Hora de Perú)
date_default_timezone_set('America/Lima');

// Verificar si el formulario fue enviado
if ($_POST) {
    // Obtener y limpiar los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $asunto = htmlspecialchars(trim($_POST['asunto']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));
    
    // Validaciones básicas
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre es requerido";
    }
    
    if (empty($email)) {
        $errores[] = "El email es requerido";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido";
    }
    
    if (empty($asunto)) {
        $errores[] = "El asunto es requerido";
    }
    
    if (empty($mensaje)) {
        $errores[] = "El mensaje es requerido";
    }
    
    // Si no hay errores, procesar el formulario
    if (empty($errores)) {
        // Guardar mensaje en archivo de texto
        $archivo_mensajes = "mensajes_contacto.txt";
        $datos_mensaje = "=== NUEVO MENSAJE DE CONTACTO ===\n";
        $datos_mensaje .= "Fecha: " . date('Y-m-d H:i:s') . "\n";
        $datos_mensaje .= "Nombre: $nombre\n";
        $datos_mensaje .= "Email: $email\n";
        $datos_mensaje .= "Asunto: $asunto\n";
        $datos_mensaje .= "Mensaje: $mensaje\n";
        $datos_mensaje .= "==============================\n\n";
        
        // Intentar guardar el archivo
        if (file_put_contents($archivo_mensajes, $datos_mensaje, FILE_APPEND | LOCK_EX)) {
            $exito = "¡Mensaje recibido exitosamente! Te contactaremos pronto.";
        } else {
            $errores[] = "Error al procesar el mensaje. Por favor, inténtalo más tarde.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>SALFORD - BURGER</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .mensaje-resultado {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            text-align: center;
        }
        .btn-volver {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mensaje-resultado">
            <?php if (isset($exito)): ?>
                <div class="alert alert-success">
                    <h3>¡Éxito!</h3>
                    <p><?php echo $exito; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <h3>Error</h3>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <a href="contact.html" class="btn btn-primary btn-volver">Volver al formulario</a>
        </div>
    </div>
</body>
</html>

<?php
// Configurar zona horaria UTC-5 (Hora de Perú)
date_default_timezone_set('America/Lima');

// Verificar si el formulario fue enviado
if ($_POST && isset($_POST['email_newsletter'])) {
    $email = htmlspecialchars(trim($_POST['email_newsletter']));
    
    // Validar email
    if (empty($email)) {
        $error = "El email es requerido";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del email no es válido";
    } else {
        // Verificar si el email ya está registrado
        $archivo_newsletter = "newsletter_suscriptores.txt";
        $suscriptores = [];
        
        if (file_exists($archivo_newsletter)) {
            $contenido = file_get_contents($archivo_newsletter);
            $suscriptores = explode("\n", $contenido);
        }
        
        // Verificar si ya está suscrito
        if (in_array($email, $suscriptores)) {
            $error = "Este email ya está suscrito a nuestro newsletter";
        } else {
            // Agregar nuevo suscriptor
            $datos_suscriptor = $email . "\n";
            file_put_contents($archivo_newsletter, $datos_suscriptor, FILE_APPEND | LOCK_EX);
            
            // También guardar con fecha en otro archivo
            $archivo_detallado = "newsletter_detallado.txt";
            $datos_detallado = "Fecha: " . date('Y-m-d H:i:s') . " - Email: " . $email . "\n";
            file_put_contents($archivo_detallado, $datos_detallado, FILE_APPEND | LOCK_EX);
            
            $exito = "¡Te has suscrito exitosamente a nuestro newsletter!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Newsletter - SALFORD BURGER</title>
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
                    <p>Recibirás noticias y ofertas especiales de Salford Burger.</p>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <h3>Error</h3>
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
            
            <a href="index.html" class="btn btn-primary btn-volver">Ir al inicio</a>
            <a href="contact.html" class="btn btn-outline-primary btn-volver">Ir a contacto</a>
        </div>
    </div>
</body>
</html>

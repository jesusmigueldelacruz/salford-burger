<?php
// Configurar zona horaria UTC-5 (Hora de Perú)
date_default_timezone_set('America/Lima');
require_once 'config/database.php';

// Verificar si el formulario fue enviado
if ($_POST && isset($_POST['email_newsletter'])) {
    $email = htmlspecialchars(trim($_POST['email_newsletter']));
    
    // Validar email
    if (empty($email)) {
        $error = "El email es requerido";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email inválido";
    } else {
        try {
            $pdo = getDBConnection();
            
            // Verificar si ya existe
            $sql_check = "SELECT id FROM newsletter_suscriptores WHERE email = :email";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([':email' => $email]);
            
            if ($stmt_check->fetch()) {
                $error = "Este email ya está suscrito";
            } else {
                // Insertar nuevo suscriptor
                $sql_insert = "INSERT INTO newsletter_suscriptores (email, fecha_suscripcion) VALUES (:email, :fecha)";
                $stmt_insert = $pdo->prepare($sql_insert);
                $stmt_insert->execute([
                    ':email' => $email,
                    ':fecha' => date('Y-m-d H:i:s')
                ]);
                $exito = "¡Suscrito exitosamente!";
            }
        } catch (Exception $e) {
            $error = "Error al procesar suscripción";
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

<?php
// Configurar zona horaria UTC-5 (Hora de Perú)
date_default_timezone_set('America/Lima');

// Incluir configuración de base de datos
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mensajes de Contacto - SALFORD BURGER</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .container-mensajes {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
        }
        .mensaje-individual {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .fecha-mensaje {
            color: #6c757d;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .sin-mensajes {
            text-align: center;
            color: #6c757d;
            padding: 50px;
        }
        .btn-volver {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container-mensajes">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Mensajes de Contacto</h1>
            <a href="contact.html" class="btn btn-primary btn-volver">Volver al formulario</a>
        </div>
        
        <?php
        try {
            $pdo = getDBConnection();
            
            // Contar mensajes
            $stmt_count = $pdo->query("SELECT COUNT(*) as total FROM mensajes_contacto");
            $total_mensajes = $stmt_count->fetch()['total'];
            
            if ($total_mensajes > 0) {
                echo "<div class='alert alert-info'>Total de mensajes: $total_mensajes</div>";
                
                // Obtener mensajes (más recientes primero)
                $stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha_registro DESC");
                $mensajes = $stmt->fetchAll();
                
                foreach ($mensajes as $mensaje) {
                    echo "<div class='mensaje-individual'>";
                    echo "<div class='fecha-mensaje'><i class='fa fa-calendar'></i> " . htmlspecialchars($mensaje['fecha_registro']) . "</div>";
                    echo "<h5><i class='fa fa-user'></i> " . htmlspecialchars($mensaje['nombre']) . "</h5>";
                    echo "<p><strong><i class='fa fa-envelope'></i> Email:</strong> " . htmlspecialchars($mensaje['email']) . "</p>";
                    echo "<p><strong><i class='fa fa-tag'></i> Asunto:</strong> " . htmlspecialchars($mensaje['asunto']) . "</p>";
                    echo "<p><strong><i class='fa fa-comment'></i> Mensaje:</strong></p>";
                    echo "<div class='border-start border-primary ps-3 ms-3'>" . nl2br(htmlspecialchars($mensaje['mensaje'])) . "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='sin-mensajes'>";
                echo "<i class='fa fa-inbox fa-3x mb-3'></i>";
                echo "<h3>No hay mensajes aún</h3>";
                echo "<p>Los mensajes aparecerán aquí cuando alguien envíe el formulario.</p>";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error al cargar mensajes: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
        
        <div class="text-center mt-4">
            <a href="index.html" class="btn btn-outline-primary me-2">Ir al inicio</a>
            <a href="contact.html" class="btn btn-primary">Ir a contacto</a>
        </div>
    </div>
    
    <!-- Font Awesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
</body>
</html>

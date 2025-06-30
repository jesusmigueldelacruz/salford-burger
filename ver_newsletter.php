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
    <title>Suscriptores Newsletter - SALFORD BURGER</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .container-suscriptores {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
        }
        .suscriptor-individual {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .fecha-suscripcion {
            color: #6c757d;
            font-size: 0.9em;
        }
        .sin-suscriptores {
            text-align: center;
            color: #6c757d;
            padding: 50px;
        }
        .btn-volver {
            margin-bottom: 30px;
        }
        .email-suscriptor {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container-suscriptores">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>📧 Suscriptores Newsletter</h1>
            <a href="contact.html" class="btn btn-primary btn-volver">Volver al formulario</a>
        </div>
        
        <?php
        try {
            $pdo = getDBConnection();
            
            // Contar suscriptores
            $stmt_count = $pdo->query("SELECT COUNT(*) as total FROM newsletter_suscriptores");
            $total_suscriptores = $stmt_count->fetch()['total'];
            
            if ($total_suscriptores > 0) {
                echo "<div class='alert alert-info'>Total de suscriptores: $total_suscriptores</div>";
                
                // Obtener suscriptores (más recientes primero)
                $stmt = $pdo->query("SELECT * FROM newsletter_suscriptores ORDER BY fecha_suscripcion DESC");
                $suscriptores = $stmt->fetchAll();
                
                foreach ($suscriptores as $suscriptor) {
                    echo "<div class='suscriptor-individual'>";
                    echo "<div>";
                    echo "<div class='email-suscriptor'><i class='fa fa-envelope me-2'></i>" . htmlspecialchars($suscriptor['email']) . "</div>";
                    echo "<div class='fecha-suscripcion'><i class='fa fa-calendar me-1'></i>" . htmlspecialchars($suscriptor['fecha_suscripcion']) . "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='sin-suscriptores'>";
                echo "<i class='fa fa-inbox fa-3x mb-3'></i>";
                echo "<h3>No hay suscriptores aún</h3>";
                echo "<p>Los suscriptores aparecerán aquí cuando alguien se suscriba.</p>";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error al cargar suscriptores: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
        
        <div class="text-center mt-4">
            <a href="index.html" class="btn btn-outline-primary me-2">Ir al inicio</a>
            <a href="contact.html" class="btn btn-primary me-2">Ir a contacto</a>
            <a href="ver_mensajes.php" class="btn btn-outline-secondary">Ver mensajes</a>
        </div>
    </div>
    
    <!-- Font Awesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
</body>
</html>

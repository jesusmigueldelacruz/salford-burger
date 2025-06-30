<?php
// Configurar zona horaria UTC-5 (Hora de Perú)
date_default_timezone_set('America/Lima');

// Archivo para ver los mensajes recibidos del formulario de contacto
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
        $archivo_mensajes = "mensajes_contacto.txt";
        
        if (file_exists($archivo_mensajes) && filesize($archivo_mensajes) > 0) {
            $contenido = file_get_contents($archivo_mensajes);
            
            // Dividir los mensajes
            $mensajes = explode("=== NUEVO MENSAJE DE CONTACTO ===", $contenido);
            
            // Eliminar el primer elemento vacío
            array_shift($mensajes);
            
            if (!empty($mensajes)) {
                echo "<div class='alert alert-info'>";
                echo "<strong>Total de mensajes:</strong> " . count($mensajes);
                echo "</div>";
                
                // Mostrar mensajes (los más recientes primero)
                $mensajes = array_reverse($mensajes);
                
                foreach ($mensajes as $mensaje) {
                    if (trim($mensaje)) {
                        echo "<div class='mensaje-individual'>";
                        
                        // Procesar el contenido del mensaje
                        $lineas = explode("\n", trim($mensaje));
                        
                        foreach ($lineas as $linea) {
                            $linea = trim($linea);
                            if (empty($linea) || $linea === "==============================") continue;
                            
                            if (strpos($linea, "Fecha:") === 0) {
                                echo "<div class='fecha-mensaje'><i class='fa fa-calendar'></i> " . htmlspecialchars($linea) . "</div>";
                            } elseif (strpos($linea, "Nombre:") === 0) {
                                echo "<h5><i class='fa fa-user'></i> " . htmlspecialchars(substr($linea, 8)) . "</h5>";
                            } elseif (strpos($linea, "Email:") === 0) {
                                echo "<p><strong><i class='fa fa-envelope'></i> Email:</strong> " . htmlspecialchars(substr($linea, 7)) . "</p>";
                            } elseif (strpos($linea, "Asunto:") === 0) {
                                echo "<p><strong><i class='fa fa-tag'></i> Asunto:</strong> " . htmlspecialchars(substr($linea, 8)) . "</p>";
                            } elseif (strpos($linea, "Mensaje:") === 0) {
                                echo "<p><strong><i class='fa fa-comment'></i> Mensaje:</strong></p>";
                                echo "<div class='border-start border-primary ps-3 ms-3'>" . nl2br(htmlspecialchars(substr($linea, 9))) . "</div>";
                            }
                        }
                        
                        echo "</div>";
                    }
                }
            } else {
                echo "<div class='sin-mensajes'>";
                echo "<i class='fa fa-inbox fa-3x mb-3'></i>";
                echo "<h3>No hay mensajes aún</h3>";
                echo "<p>Los mensajes del formulario de contacto aparecerán aquí.</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='sin-mensajes'>";
            echo "<i class='fa fa-inbox fa-3x mb-3'></i>";
            echo "<h3>No hay mensajes aún</h3>";
            echo "<p>Los mensajes del formulario de contacto aparecerán aquí cuando alguien envíe el formulario.</p>";
            echo "</div>";
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

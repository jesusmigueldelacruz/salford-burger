<?php
// Archivo para probar la conexión a la base de datos
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Prueba de Conexión - SALFORD BURGER</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .container-prueba {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
        }
        .test-item {
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .success {
            background-color: #d1edff;
            border-color: #b6d7ff;
            color: #004085;
        }
        .error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container-prueba">
        <h1 class="text-center mb-4">🔧 Prueba de Conexión a Base de Datos</h1>
        
        <?php
        echo "<div class='test-item'>";
        echo "<h4>1. Verificando configuración de zona horaria...</h4>";
        echo "<p><strong>Zona horaria actual:</strong> " . date_default_timezone_get() . "</p>";
        echo "<p><strong>Fecha y hora actual:</strong> " . date('Y-m-d H:i:s') . "</p>";
        echo "</div>";
        
        echo "<div class='test-item'>";
        echo "<h4>2. Probando conexión a MySQL...</h4>";
        
        if (testConnection()) {
            echo "<div class='success'>";
            echo "<p><strong>✅ ¡Conexión exitosa!</strong></p>";
            echo "<p>La conexión a la base de datos 'salford_burger' funciona correctamente.</p>";
            echo "</div>";
            
            // Probar las tablas
            try {
                $pdo = getDBConnection();
                
                // Verificar tabla mensajes_contacto
                $stmt = $pdo->query("DESCRIBE mensajes_contacto");
                $columns = $stmt->fetchAll();
                
                echo "<h5>📋 Estructura de tabla 'mensajes_contacto':</h5>";
                echo "<table class='table table-sm'>";
                echo "<thead><tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por defecto</th></tr></thead>";
                echo "<tbody>";
                foreach ($columns as $column) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Default']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                
                // Verificar tabla newsletter_suscriptores
                $stmt = $pdo->query("DESCRIBE newsletter_suscriptores");
                $columns = $stmt->fetchAll();
                
                echo "<h5>📧 Estructura de tabla 'newsletter_suscriptores':</h5>";
                echo "<table class='table table-sm'>";
                echo "<thead><tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por defecto</th></tr></thead>";
                echo "<tbody>";
                foreach ($columns as $column) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
                    echo "<td>" . htmlspecialchars($column['Default']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                
                // Contar registros existentes
                $stmt = $pdo->query("SELECT COUNT(*) as total FROM mensajes_contacto");
                $count_mensajes = $stmt->fetch()['total'];
                
                $stmt = $pdo->query("SELECT COUNT(*) as total FROM newsletter_suscriptores");
                $count_newsletter = $stmt->fetch()['total'];
                
                echo "<div class='success'>";
                echo "<h5>📊 Estado actual de las tablas:</h5>";
                echo "<p><strong>Mensajes de contacto:</strong> $count_mensajes registros</p>";
                echo "<p><strong>Suscriptores newsletter:</strong> $count_newsletter registros</p>";
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>";
                echo "<p><strong>❌ Error al verificar tablas:</strong></p>";
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
                echo "</div>";
            }
            
        } else {
            echo "<div class='error'>";
            echo "<p><strong>❌ Error de conexión</strong></p>";
            echo "<p>No se pudo conectar a la base de datos. Verifica:</p>";
            echo "<ul>";
            echo "<li>Que MySQL esté corriendo en XAMPP</li>";
            echo "<li>Que la base de datos 'salford_burger' exista</li>";
            echo "<li>Las credenciales de conexión</li>";
            echo "</ul>";
            echo "</div>";
        }
        echo "</div>";
        ?>
        
        <div class="text-center mt-4">
            <a href="contact.html" class="btn btn-primary me-2">Ir al formulario</a>
            <a href="ver_mensajes.php" class="btn btn-outline-primary">Ver mensajes</a>
        </div>
        
        <div class="alert alert-info mt-4">
            <h5>🚀 Próximos pasos:</h5>
            <p>Si la conexión es exitosa, procederemos a:</p>
            <ol>
                <li>Migrar el formulario de contacto a MySQL</li>
                <li>Migrar el sistema de newsletter a MySQL</li>
                <li>Actualizar el visor de mensajes</li>
                <li>Opcional: Migrar datos existentes de archivos .txt</li>
            </ol>
        </div>
    </div>
</body>
</html>

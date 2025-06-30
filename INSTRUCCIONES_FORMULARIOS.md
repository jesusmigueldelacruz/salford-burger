# Configuración de Formularios con XAMPP

## Pasos para hacer funcionar los formularios:

### 1. Configuración de XAMPP
- Asegúrate de que XAMPP esté instalado y funcionando
- Inicia Apache desde el panel de control de XAMPP
- Opcional: Inicia MySQL si quieres usar base de datos

### 2. Ubicación de archivos
- Coloca todos los archivos del proyecto en: `C:\xampp\htdocs\salford-burger\`
- Los archivos PHP ya creados (`procesar_contacto.php` y `procesar_newsletter.php`) están listos

### 3. Acceso al sitio
- Abre tu navegador y ve a: `http://localhost/salford-burger/contact.html`
- También puedes acceder desde: `http://127.0.0.1/salford-burger/contact.html`

### 4. Configuración del email (Opcional)
Para que funcione el envío de emails, necesitas configurar PHP:

#### Opción A: Usando Gmail SMTP (Recomendado)
1. Edita el archivo `C:\xampp\php\php.ini`
2. Busca la sección `[mail function]` y configura:
```ini
SMTP = smtp.gmail.com
smtp_port = 587
sendmail_from = tu-email@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```

3. Edita el archivo `C:\xampp\sendmail\sendmail.ini`:
```ini
smtp_server=smtp.gmail.com
smtp_port=587
auth_username=tu-email@gmail.com
auth_password=tu-contraseña-de-aplicacion
force_sender=tu-email@gmail.com
```

#### Opción B: Sin configurar email
- Los formularios funcionarán, pero no enviarán emails
- Los datos se guardarán en archivos de texto:
  - `mensajes_contacto.txt` - Mensajes del formulario de contacto
  - `newsletter_suscriptores.txt` - Emails del newsletter
  - `newsletter_detallado.txt` - Newsletter con fechas

### 5. Prueba de funcionamiento
1. Ve a `http://localhost/salford-burger/contact.html`
2. Llena el formulario de contacto
3. Haz clic en "Enviar mensaje"
4. Deberías ver una página de confirmación
5. Verifica los archivos de texto en la carpeta del proyecto

### 6. Funcionalidades implementadas

#### Formulario de contacto:
- Validación de campos requeridos
- Validación de formato de email
- Envío de email (si está configurado)
- Guardado en archivo de texto como respaldo
- Página de confirmación con manejo de errores

#### Newsletter:
- Suscripción al newsletter
- Validación de email
- Prevención de emails duplicados
- Guardado en archivos de texto

### 7. Archivos creados:
- `procesar_contacto.php` - Procesa el formulario de contacto
- `procesar_newsletter.php` - Procesa la suscripción al newsletter
- `contact.html` - Modificado para incluir los formularios funcionales

### 8. Personalización adicional
Puedes modificar los archivos PHP para:
- Cambiar los emails de destino
- Agregar más validaciones
- Integrar con una base de datos
- Personalizar los mensajes de respuesta
- Agregar más campos al formulario

### 9. Seguridad
Los formularios incluyen:
- Validación del lado del servidor
- Escape de caracteres HTML para prevenir XSS
- Validación de formato de email
- Verificación de datos requeridos

### 10. Troubleshooting
Si los formularios no funcionan:
1. Verifica que Apache esté corriendo en XAMPP
2. Revisa que los archivos estén en la carpeta correcta
3. Comprueba los permisos de escritura en la carpeta
4. Verifica la configuración de PHP en `php.ini`
5. Revisa los logs de error de Apache en `C:\xampp\apache\logs\error.log`

# Guía de Instalación Local - Sistema de Farmacia

## Requisitos Previos

1. **PHP 7.4 o superior** (recomendado PHP 8.0+)
2. **MySQL/MariaDB** 5.7 o superior
3. **Composer** (gestor de dependencias de PHP)
4. **Servidor Web** (XAMPP, WAMP, Laragon, o servidor PHP integrado)

## Opción 1: Usando XAMPP (Recomendado para Windows)

### Paso 1: Instalar XAMPP
1. Descarga XAMPP desde: https://www.apachefriends.org/
2. Instala XAMPP en `C:\xampp` (o la ruta que prefieras)
3. Inicia los servicios **Apache** y **MySQL** desde el panel de control de XAMPP

### Paso 2: Configurar el Proyecto
1. Copia la carpeta del proyecto a: `C:\xampp\htdocs\SISTEMA FARMACIA`
   - O mueve la carpeta completa a `C:\xampp\htdocs\`

### Paso 3: Crear la Base de Datos
1. Abre phpMyAdmin: http://localhost/phpmyadmin
2. Crea una nueva base de datos llamada: `clinaxkk_farmacia`
3. Importa el archivo SQL:
   - Selecciona la base de datos `clinaxkk_farmacia`
   - Ve a la pestaña "Importar"
   - Selecciona el archivo `clinaxkk_farmacia.sql`
   - Haz clic en "Continuar"

### Paso 4: Configurar la Conexión a la Base de Datos
Edita el archivo `conexion/clsConexion.php` y modifica las siguientes líneas:

```php
$host = "localhost";  // o "127.0.0.1"
$db_name = "clinaxkk_farmacia";
$user = "root";  // Usuario por defecto de XAMPP
$pass = "";  // Contraseña por defecto de XAMPP (vacía)
```

### Paso 5: Instalar Dependencias de Composer
Abre una terminal en la carpeta del proyecto y ejecuta:

```bash
composer install
```

### Paso 6: Acceder al Sistema
1. Abre tu navegador web
2. Ve a: `http://localhost/SISTEMA FARMACIA/index.php`
   - O si copiaste solo el contenido: `http://localhost/index.php`

## Opción 2: Usando el Servidor PHP Integrado

### Paso 1: Instalar PHP y MySQL
1. Descarga PHP desde: https://windows.php.net/download/
2. Instala MySQL desde: https://dev.mysql.com/downloads/installer/
3. Instala Composer desde: https://getcomposer.org/

### Paso 2: Configurar PHP
1. Agrega PHP a las variables de entorno del sistema
2. Verifica la instalación ejecutando: `php -v`

### Paso 3: Crear la Base de Datos
1. Inicia MySQL: `mysql -u root -p`
2. Crea la base de datos:
```sql
CREATE DATABASE clinaxkk_farmacia;
USE clinaxkk_farmacia;
SOURCE "ruta/completa/a/clinaxkk_farmacia.sql";
```

### Paso 4: Configurar la Conexión
Edita `conexion/clsConexion.php` con los datos de tu base de datos local.

### Paso 5: Instalar Dependencias
```bash
composer install
```

### Paso 6: Iniciar el Servidor
En la carpeta del proyecto, ejecuta:

```bash
php -S localhost:8000
```

### Paso 7: Acceder al Sistema
Abre tu navegador en: `http://localhost:8000/index.php`

## Opción 3: Usando Laragon (Alternativa para Windows)

1. Descarga Laragon desde: https://laragon.org/
2. Instala Laragon
3. Copia el proyecto a: `C:\laragon\www\SISTEMA FARMACIA`
4. Inicia Laragon y activa Apache y MySQL
5. Sigue los pasos 3-6 de la Opción 1

## Configuración Adicional

### Certificado SUNAT (Opcional)
Si necesitas usar la funcionalidad de facturación electrónica:
1. Coloca tu certificado en: `certificado/foto/certificado.pem`
2. Configura las credenciales en `config.php` si es necesario

### Permisos de Carpetas (Linux/Mac)
Si estás en Linux o Mac, asegúrate de dar permisos de escritura a las carpetas necesarias:
```bash
chmod -R 755 "carpeta_del_proyecto"
```

## Solución de Problemas

### Error de Conexión a la Base de Datos
- Verifica que MySQL esté corriendo
- Revisa las credenciales en `conexion/clsConexion.php`
- Asegúrate de que la base de datos existe y está importada correctamente

### Error 404 - Página no encontrada
- Verifica que el servidor web esté corriendo
- Revisa la ruta en el navegador
- Asegúrate de que los archivos estén en la carpeta correcta del servidor

### Error de Composer
- Verifica que Composer esté instalado: `composer --version`
- Si hay problemas, elimina la carpeta `vendor` y ejecuta `composer install` nuevamente

### Problemas con Rutas
- Asegúrate de que todas las rutas en los archivos PHP sean relativas o estén configuradas correctamente
- Revisa que los archivos de assets (CSS, JS, imágenes) estén en sus carpetas correspondientes

## Notas Importantes

⚠️ **Seguridad**: Las credenciales de la base de datos están hardcodeadas en el código. Para producción, considera usar variables de entorno o un archivo de configuración separado.

⚠️ **Base de Datos**: El archivo SQL `clinaxkk_farmacia.sql` debe importarse completamente para que el sistema funcione correctamente.

## Usuarios por Defecto

Después de importar la base de datos, verifica en la tabla `usuario` cuáles son los usuarios disponibles. Si no hay usuarios, necesitarás crear uno manualmente en la base de datos.

---

**Desarrollado por Factosys Peru**

# LEEME.txt - Instrucciones de Instalación

## Requisitos previos

- **Versión de PHP**: 8.2.12
- **Base de datos**: MySQL 8.2.12

## Pasos para instalar el proyecto

### 1. Clonar o descargar el repositorio

Si el proyecto está disponible en un repositorio de Git (por ejemplo, GitHub), puedes clonarlo usando el siguiente comando:

```bash
git clone https://url-del-repositorio.git
```

Si no usas Git, puedes descargar el archivo comprimido del proyecto y descomprimirlo en el directorio de tu elección.

### 2. Configurar el servidor local

Si estás utilizando un servidor local como **XAMPP**, **MAMP**, **WAMP** o similar:

- Asegúrate de que los servicios de **Apache** y **MySQL** estén en ejecución.

### 3. Crear y configurar la base de datos

- Accede a **phpMyAdmin** o tu herramienta preferida para gestionar bases de datos.
- Crea una nueva base de datos con el nombre de **nombre_de_tu_base_de_datos**.
- Si el proyecto incluye un archivo SQL para importar, ejecuta el siguiente comando en **phpMyAdmin**:
  - Selecciona la base de datos recién creada.
  - Haz clic en **Importar** y selecciona el archivo **base_de_datos.sql** incluido en el proyecto (si existe) para crear las tablas necesarias.
  - Si no hay archivo SQL, deberás crear las tablas manualmente, de acuerdo con la estructura del sistema.

### 4. Configurar las credenciales de la base de datos

- Abre el archivo de configuración de la base de datos, que podría ser un archivo `.env`, `config.php`, o similar.
- Ajusta las credenciales de la base de datos con los valores correctos:

```php
// Configuración de la base de datos
define('DB_HOST', 'localhost');         // Dirección del servidor de base de datos
define('DB_USER', 'tu_usuario');        // Usuario de la base de datos
define('DB_PASS', 'tu_contraseña');    // Contraseña de la base de datos
define('DB_NAME', 'nombre_de_tu_base_de_datos');  // Nombre de la base de datos
```

### 5. Instalar las dependencias (si aplica)

Si el proyecto usa **Composer** para gestionar dependencias de PHP:

- Ejecuta el siguiente comando en la terminal dentro del directorio raíz del proyecto:

```bash
composer install
```

### 6. Configuración del entorno (si aplica)

Si tu proyecto utiliza variables de entorno para la configuración, asegúrate de crear un archivo `.env` en el directorio raíz del proyecto. Un ejemplo de archivo `.env` sería:

```
APP_ENV=local
APP_DEBUG=true
DB_HOST=localhost
DB_USER=tu_usuario
DB_PASS=tu_contraseña
DB_NAME=nombre_de_tu_base_de_datos
```

### 7. Verificación

- Accede al proyecto a través de tu navegador en la siguiente URL: `http://localhost/nombre_del_proyecto`.

Si todo está configurado correctamente, deberías poder ver la página de inicio del sistema de registro de productos.

### 8. Listo para usar

Una vez que hayas seguido los pasos anteriores, el sistema estará listo para ser utilizado. Puedes comenzar a registrar productos, gestionar inventarios y acceder a todas las funcionalidades disponibles.

## Notas adicionales

- **Permisos de archivos**: Asegúrate de que todos los archivos y carpetas tengan los permisos adecuados, especialmente en entornos de producción.
- **Errores comunes**:
  - Si el servidor no puede conectar con la base de datos, verifica que las credenciales de acceso sean correctas.
  - Si ves mensajes de error en el navegador, revisa los logs de **Apache** o **Nginx** para obtener más información.

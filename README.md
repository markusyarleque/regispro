# LEEME.txt - Instrucciones de Instalación

## Requisitos previos

- **Versión de PHP**: 8.2.12
- **Base de datos**: MySQL 8.2.12

## Pasos para instalar el proyecto

### 1. Clonar o descargar el repositorio

Utiliza el siguiente comando para clonar el proyecto:

```bash
git clone https://github.com/markusyarleque/regispro.git
```

Si no usas Git, puedes descargar el archivo comprimido del proyecto y descomprimirlo en el directorio de tu elección.

### 2. Configurar el servidor local

Si estás utilizando un servidor local como **XAMPP**, **MAMP**, **WAMP** o similar:

- Asegúrate de que los servicios de **Apache** y **MySQL** estén en ejecución.

### 3. Crear y configurar la base de datos

- Accede a **phpMyAdmin** o tu herramienta preferida para gestionar bases de datos.
- Crea una nueva base de datos con el nombre de **bd_registro**.
- Ejecuta el siguiente comando en **phpMyAdmin**:
  - Selecciona la base de datos recién creada.
  - Haz clic en **Importar** y selecciona el archivo **base_de_datos.sql** incluido en la carpeta **sql** del proyecto para crear las tablas necesarias.

### 4. Configuración del entorno

Crear un archivo `.env` en el directorio raíz del proyecto con los siguientes valores:

```
DB_HOST=localhost
DB_USER=root (Usuario del host)
DB_PASSWORD="" (contraseña del host)
DB_NAME=bd_registro (nombre de la base de datos)
VERSION=1.0.0
```

### 5. Verificación

- Accede al proyecto a través de tu navegador en la siguiente URL: `http://localhost/regispro`.

Si todo está configurado correctamente, deberías poder ver la página de inicio del sistema de registro de productos.

### 6. Listo para usar

Una vez que hayas seguido los pasos anteriores, el sistema estará listo para ser utilizado. Puedes comenzar a registrar productos y acceder a todas las funcionalidades disponibles.

## Notas adicionales

- **Permisos de archivos**: Asegúrate de que todos los archivos y carpetas tengan los permisos adecuados, especialmente en entornos de producción.
- **Errores comunes**:
  - Si el servidor no puede conectar con la base de datos, verifica que las credenciales de acceso sean correctas.
  - Si ves mensajes de error en el navegador, revisa los logs de **Apache** o **Nginx** para obtener más información.

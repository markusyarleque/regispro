<?php
$errors = array();

/*--------------------------------------------------------------*/
/* Función para remover carácteres HTML
/*--------------------------------------------------------------*/
function remove_junk($str)
{
    $str = nl2br($str);
    $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
    return $str;
}
/*--------------------------------------------------------------*/
/* Función para poner en mayúscula el primer caracter
/*--------------------------------------------------------------*/
function first_character($str)
{
    $val = str_replace('-', " ", $str);
    $val = ucfirst($val);
    return $val;
}
/*--------------------------------------------------------------*/
/* Función para verificar que los inputs no estén vacíos
/*--------------------------------------------------------------*/
function validate_fields($var)
{
    global $errors;
    foreach ($var as $field) {
        $val = remove_junk($_POST[$field]);
        if (isset($val) && $val == '') {
            $errors = $field . " - No puede estar en blanco.";
            return $errors;
        }
    }
}
/*--------------------------------------------------------------*/
/* Función para redireccionar
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Función para cargar el archivo .env
/*--------------------------------------------------------------*/
function loadEnv($filePath)
{
    // Validación para la existencia del archivo
    if (!file_exists($filePath)) {
        throw new Exception("El archivo .env no existe.");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Saltar los comentarios y las líneas vacías
        if (strpos(trim($line), '#') === 0 || strpos(trim($line), '=') === false) {
            continue;
        }

        // Separar la clave y el valor
        list($name, $value) = explode('=', $line, 2);

        // Eliminar espacios innecesarios
        $name = trim($name);
        $value = trim($value);

        // Quitar comillas dobles o simples si están presentes
        if (preg_match('/^["\'](.*)["\']$/', $value, $matches)) {
            $value = $matches[1];
        }

        // Establecer la variable de entorno
        putenv("$name=$value");
        $_ENV[$name] = $value;
    }
}
/*--------------------------------------------------------------*/
/* Función para hacer legible la fecha y hora actual
/*--------------------------------------------------------------*/
function make_date()
{
    return date("Y-m-d H:i:s");
}

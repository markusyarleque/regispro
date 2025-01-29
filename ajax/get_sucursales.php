<?php
require_once('../includes/load.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['bodega_id'])) {
    // Obtener el dato de entrada
    $bodega_id = (int) $_GET['bodega_id'];

    $sucursales = find_sucursal_by_bodega($bodega_id);

    echo json_encode($sucursales ?: []);
}

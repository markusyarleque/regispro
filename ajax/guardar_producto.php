<?php
require_once('../includes/load.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si la solicitud es AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Acceso no permitido.']);
    exit;
}

// Validación de campos requeridos
$req_fields = array('codigo', 'nombre', 'bodega_id', 'sucursal_id', 'moneda_id', 'precio', 'descripcion');
validate_fields($req_fields);

//  Verificar si existen errores en los campos obligatorios
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios.']);
    exit;
}

// Obtener y sanitizar los datos de entrada
$codigo       = remove_junk($db->escape($_POST['codigo']));
$nombre       = remove_junk($db->escape($_POST['nombre']));
$bodega_id    = remove_junk($db->escape($_POST['bodega_id']));
$sucursal_id  = remove_junk($db->escape($_POST['sucursal_id']));
$moneda_id    = remove_junk($db->escape($_POST['moneda_id']));
$precio       = remove_junk($db->escape($_POST['precio']));
$descripcion  = remove_junk($db->escape($_POST['descripcion']));
$date         = make_date();
$materiales   = isset($_POST['materiales']) ? $_POST['materiales'] : [];

// Validación de formato de la columna código de producto
if (!preg_match("/^[a-zA-Z0-9]{5,15}$/", $codigo)) {
    echo json_encode(['success' => false, 'message' => 'El código debe tener entre 5 y 15 caracteres y solo puede contener letras y números.']);
    exit;
}

// Validación para que al menos se eligan 2 materiales
if (count($materiales) < 2) {
    echo json_encode(['success' => false, 'message' => 'Debe seleccionar al menos 2 materiales.']);
    exit;
}

// Insercción en la tabla productos
$query  = "INSERT INTO productos (";
$query .= "codigo,nombre,bodega_id,sucursal_id,moneda_id,precio,descripcion,fecha_creacion";
$query .= ") VALUES (";
$query .= " '{$codigo}', '{$nombre}', '{$bodega_id}', '{$sucursal_id}', '{$moneda_id}', '{$precio}', '{$descripcion}', '{$date}'";
$query .= ")";

if ($db->query($query)) {
    // Obtener el ID del producto insertado
    $producto_id = $db->insert_id();

    // Preparar las consultas para insertar los materiales
    $insert_values = [];
    foreach ($materiales as $material_id) {
        $material_id = (int)$material_id;
        $insert_values[] = "('$producto_id', '$material_id')";
    }

    // Insercción en la tabla producto_material
    $query_materiales = "INSERT INTO producto_material (producto_id, material_id) VALUES " . implode(", ", $insert_values);
    if ($db->query($query_materiales)) {
        echo json_encode(['success' => true, 'message' => 'Producto guardado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar los materiales del producto.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el producto.']);
}

exit;

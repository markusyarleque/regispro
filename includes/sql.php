<?php
require_once('load.php');

/*--------------------------------------------------------------*/
/* Función para encontrar todas las filas de una tabla
/*--------------------------------------------------------------*/
function find_all($table)
{
    global $db;
    if (tableExists($table)) {
        return find_by_sql("SELECT * FROM " . $db->escape($table) . " ORDER BY 1 asc");
    }
}
/*--------------------------------------------------------------*/
/* Función para realizar consultas
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
    global $db;
    $result = $db->query($sql);
    if ($result === false) {
        echo "Error en la consulta find_by_sql: " . $db->error;
        return false;
    }
    $result_set = $db->while_loop($result);
    return $result_set;
}
/*--------------------------------------------------------------*/
/* Función para encontrar datos de una tabla por id
/*--------------------------------------------------------------*/
function find_by_id($table, $id)
{
    global $db;
    $id = (int)$id;
    if (tableExists($table)) {
        $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
        if ($result = $db->fetch_assoc($sql))
            return $result;
        else
            return null;
    }
}
/*--------------------------------------------------------------*/
/* Función para borrar datos de una tabla por id
/*--------------------------------------------------------------*/
function delete_by_id($table, $id)
{
    global $db;
    if (tableExists($table)) {
        $sql = "DELETE FROM " . $db->escape($table);
        $sql .= " WHERE id=" . $db->escape($id);
        $sql .= " LIMIT 1";
        $db->query($sql);
        return ($db->affected_rows() === 1) ? true : false;
    }
}
/*--------------------------------------------------------------*/
/* Función para contar el total de id por nombre de una tabla
/*--------------------------------------------------------------*/

function count_by_id($table)
{
    global $db;
    if (tableExists($table)) {
        $sql    = "SELECT COUNT(id) AS total FROM " . $db->escape($table);
        $result = $db->query($sql);
        if ($result === false) {
            echo "Error en la consulta count by table: " . $db->error;
            return false;
        }
        return ($db->fetch_assoc($result));
    }
}
/*--------------------------------------------------------------*/
/* Función para validar la existencia de una tabla
/*--------------------------------------------------------------*/
function tableExists($table)
{
    global $db;
    $table_exit = $db->query('SHOW TABLES FROM ' . DB_NAME . ' LIKE "' . $db->escape($table) . '"');
    if ($table_exit) {
        if ($db->num_rows($table_exit) > 0)
            return true;
        else
            return false;
    }
}
/*--------------------------------------------------------------*/
/* Función para encontrar todos los registros de la tabla productos
/* unido con las tablas bodega, sucursal, moneda y producto_material
/*--------------------------------------------------------------*/
function join_product_table()
{
    global $db;
    $sql  = " SELECT p.id AS producto_id, p.codigo, p.nombre AS producto, b.id AS bodega_id, ";
    $sql  = " b.nombre AS bodega, s.id AS sucursal_id, s.nombre AS sucursal, m.id AS moneda_id, ";
    $sql  = " m.nombre AS moneda, m.simbolo AS simbolo, p.precio, p.descripcion, p.fecha_creacion, ";
    $sql  = " COALESCE(string_agg(mat.nombre, ', '), 'Sin materiales') AS materiales ";
    $sql  .= " FROM productos p";
    $sql  .= " LEFT JOIN bodegas b ON b.id = p.bodega_id";
    $sql  .= " LEFT JOIN sucursales s ON s.id = p.sucursal_id";
    $sql  .= " LEFT JOIN monedas m ON m.id = p.moneda_id";
    $sql  .= " LEFT JOIN producto_material pm ON p.id = pm.producto_id";
    $sql  .= " LEFT JOIN materiales mat ON pm.material_id = mat.id";
    $sql  .= " GROUP BY p.id, p.codigo, p.nombre, b.id, b.nombre, s.id, s.nombre, m.id, ";
    $sql  .= " m.nombre, m.simbolo, p.precio, p.descripcion, p.fecha_creacion";
    $sql  .= " ORDER BY p.id";
    return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Función para encontrar productos por nombre
/*--------------------------------------------------------------*/
function find_all_product_info_by_name($name)
{
    global $db;
    $sql  = "SELECT * FROM productos ";
    $sql .= " WHERE nombre ='{$name}'";
    $sql .= " LIMIT 1";
    return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Función para obtener el siguiente valor del autoincrement por nombre de tabla
/*--------------------------------------------------------------*/
function get_next_ai($table)
{
    global $db;
    if (tableExists($table)) {
        $table = $db->escape($table);
        $sql    = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME='$table'";
        $result = $db->query($sql);
        if ($result === false) {
            echo "Error en la consulta get_next_ai: " . $db->error;
            return false;
        }
        $row = $db->fetch_assoc($result);
        return $row ? $row['AUTO_INCREMENT'] : false;
    }
    return false;
}
/*--------------------------------------------------------------*/
/* Función para validar códigos únicos
/*--------------------------------------------------------------*/
function validate_code($codigo)
{
    global $db;
    $sql  = "SELECT COUNT(*) AS total FROM productos ";
    $sql .= " WHERE codigo ='{$codigo}'";
    $result = find_by_sql($sql);
    return isset($result[0]['total']) ? (int)$result[0]['total'] : 0;
}
/*--------------------------------------------------------------*/
/* Función para encontrar sucursales por id de bodega
/*--------------------------------------------------------------*/
function find_sucursal_by_bodega($bodega)
{
    global $db;
    $bodega = (int)$bodega;
    $sql = "SELECT id, nombre FROM sucursales WHERE bodega_id='{$db->escape($bodega)}'";
    $result = $db->query($sql);
    if ($result === false) {
        echo "Error en la consulta para obtener las ventas por fecha: " . $db->error;
        return null;
    }
    return $db->while_loop($result);
}

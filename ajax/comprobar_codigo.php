<?php
require_once('../includes/load.php');
if (isset($_POST['codigo']) && strlen($_POST['codigo'])) {
    $codigo = remove_junk($db->escape($_POST['codigo']));
    $count = validate_code($codigo);
    if ($count > 0) {
        echo "existe";
    } else {
        echo "unico";
    }
}

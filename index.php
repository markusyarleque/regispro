<?php
require_once('includes/load.php');
$bodegas = find_all('bodegas');
$monedas = find_all('monedas');
$materiales = find_all('materiales');

include_once('layouts/header.php');
?>
<div class="container">
    <h1>Formulario de Producto</h1>
    <form id="form-producto" method="post" action="index.php">
        <div class="form-grid">
            <div class="form-group">
                <label>Código</label>
                <input type="text" name="codigo" id="codigo">
            </div>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            <div class="form-group">
                <label>Bodega</label>
                <select name="bodega_id" id="bodega">
                    <option value=""></option>
                    <?php foreach ($bodegas as $bodega): ?>
                        <option value="<?php echo (int)$bodega['id'] ?>">
                            <?php echo $bodega['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Sucursal</label>
                <select name="sucursal_id" id="sucursal">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group">
                <label>Moneda</label>
                <select name="moneda_id" id="moneda">
                    <option value=""></option>
                    <?php foreach ($monedas as $mon): ?>
                        <option value="<?php echo (int)$mon['id'] ?>">
                            <?php echo $mon['simbolo'] ?> - <?php echo $mon['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Precio</label>
                <input type="number" step="0.01" name="precio" min="0.01" id="precio">
            </div>
            <div class="form-group full-width">
                <label>Material del Producto</label>
                <div class="checkbox-group">
                    <?php foreach ($materiales as $mat): ?>
                        <input type="checkbox" name="materiales[]" value="<?php echo (int)$mat['id'] ?>">
                        <?php echo $mat['nombre'] ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group full-width">
                <label>Descripción</label>
                <textarea name="descripcion" id="descripcion"></textarea>
            </div>
        </div>
        <button type="button" name="guardar" id="btnGuardar">Guardar Producto</button>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
document.addEventListener("DOMContentLoaded", function () {
    // Obtenemos los elementos select bodega y sucursal del formulario
    const bodegaSelect = document.getElementById("bodega");
    const sucursalSelect = document.getElementById("sucursal");

    // Evento de cambio en el select de bodega
    bodegaSelect.addEventListener("change", function () {
        const bodegaId = this.value;

        // Ocultamos las sucursales al inicio y deshabilitamos el select
        sucursalSelect.innerHTML = '<option value=""></option>';
        sucursalSelect.setAttribute("disabled", "disabled");

        if (bodegaId) {
            // Realizar la petición AJAX
            fetch("ajax/get_sucursales.php?bodega_id=" + bodegaId)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        //Habilitamos el select de sucursales
                        sucursalSelect.removeAttribute("disabled");
                        // Filtramos y agregamos solo las sucursales de la bodega seleccionada
                        data.forEach(sucursal => {
                            let option = document.createElement("option");
                            option.value = sucursal.id;
                            option.textContent = sucursal.nombre;
                            sucursalSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error("Error al cargar sucursales:", error));
        }
    });

    // Evento de clic en el botón guardar para invocar a las validaciones previas del formulario
    document.getElementById("btnGuardar").addEventListener("click", async function () {
        await validarFormulario();
    });
});

// Función para validar el input código
async function validarCodigo() {
    // Declaración de constantes para obtener los elementos codigo y codigo-error
    const codigo = document.getElementById('codigo').value;

    // Validación para campo vacío
    if (codigo.trim() === "") {
        alert("El código del producto no puede estar en blanco.");
        return false;
    }
    // Usamos regex para validar el límite de carácteres y que solo tenga letras y números
    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]+$/;
    if (!regex.test(codigo)) {
        alert("El código del producto debe contener letras y números.");
        return false;
    }
    // Validación para longitud de caracteres
    if (codigo.length < 5 || codigo.length > 15) {
        alert("El código del producto debe tener entre 5 y 15 caracteres.");
        return false;
    }
    // Validación que invoca a la función de existencia en la bd
    const existe = await existeCodigo(codigo);
    if (existe) {
        alert("El código del producto ya está registrado.");
        return false;
    }
    return true;
}

// Función asíncrona que valida la existencia del código en la bd
async function existeCodigo(codigo) {
    try {
        const response = await fetch('ajax/comprobar_codigo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `codigo=${encodeURIComponent(codigo)}`
        });
        const text = await response.text();
        return text.trim() === 'existe';
    } catch (error) {
        console.error("Error en la solicitud para validar código de producto: ", error);
        return false
    }
}

// Función para validar el input nombre
function validarNombre() {
    // Declaración de constantes para obtener los elementos nombre
    const nombre = document.getElementById('nombre').value;

    // Validación para campo vacío
    if (nombre.trim() === "") {
        alert("El nombre del producto no puede estar en blanco.");
        return false;
    }
    // Validación para longitud de caracteres
    if (nombre.length < 2 || nombre.length > 50) {
        alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
        return false;
    }
    return true;
}

// Función para validar el select bodega
function validarBodega() {
    // Obtenemos el select de bodega
    const bodega = document.getElementById("bodega");

    if (bodega.value === "") {
        alert("Debe seleccionar una bodega.");
        return false;
    }
    return true;
}

// Función para validar el select sucursal
function validarSucursal() {
    // Obtenemos el select de sucursal
    const sucursal = document.getElementById("sucursal");

    if (sucursal.value === "") {
        alert("Debe seleccionar una sucursal para la bodega seleccionada.");
        return false;
    }
    return true;
}

// Función para validar el select moneda
function validarMoneda() {
    // Obtenemos el select de moneda
    const moneda = document.getElementById("moneda");

    if (moneda.value === "") {
        alert("Debe seleccionar una moneda para el producto.");
        return false;
    }
    return true;
}

// Función para validar el input precio
function validarPrecio() {
    // Declaración de constantes para obtener los elementos precio
    const precio = document.getElementById('precio').value;

    // Validación para campo vacío
    if (precio.trim() === "") {
        alert("El precio del producto no puede estar en blanco.");
        return false;
    }
    // Usamos regex para validar el número positivo con hasta dos decimales
    const regex = /^\d+(\.\d{1,2})?$/;
    if (!regex.test(precio) || parseFloat(precio) <= 0) {
        alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
        return false;
    }
    return true;
}

// Función para validar el checkbox material
function validarMaterial() {
    // Obtenemos todos los materiales del checkbox
    const materiales = document.querySelectorAll('input[name="materiales[]"]');

    // Contar cuántos checkboxes están seleccionados
    const seleccionados = Array.from(materiales).filter(cb => cb.checked).length;

    // Validar si hay al menos dos checkboxes seleccionados
    if (seleccionados < 2) {
        alert("Debe seleccionar al menos dos materiales para el producto.");
        return false;
    }

    return true;
}

// Función para validar el input descripcion
function validarDescripcion() {
    // Declaración de constantes para obtener los elementos descripcion
    const descripcion = document.getElementById('descripcion').value;

    // Validación para campo vacío
    if (descripcion.trim() === "") {
        alert("La descripción del producto no puede estar en blanco.");
        return false;
    }
    // Validación para longitud de caracteres
    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
        return false;
    }
    return true;
}

// Función que invoca a todas las validaciones del formulario
async function validarFormulario() {
    // Llamamos a la funcion para validar código
    const codigoValido = await validarCodigo();
    // Llamamos a todas las funciones de validación
    if (!codigoValido || !validarNombre() || !validarBodega() || !validarSucursal() || !validarMoneda() || !validarPrecio() ||
        !validarMaterial() || !validarDescripcion()) {
        return;
    }

    // Si todas las validaciones pasan, enviamos el formulario por AJAX
    enviarFormulario();
}

// Función que envía el formulario con AJAX
function enviarFormulario() {
    let formData = new FormData(document.getElementById("form-producto"));

    fetch("ajax/guardar_producto.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Producto guardado exitosamente.");
                location.reload();
            } else {
                alert("Error al guardar el producto.");
            }
        })
        .catch(error => console.error("Error en la solicitud AJAX: ", error));
}
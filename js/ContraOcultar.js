
document.addEventListener("DOMContentLoaded", function() {
    // Seleccionar el campo de contraseña y el ícono para cambiar el tipo de contraseña
    const contra = document.getElementById("txtContrasenia");  // Obtener el campo de contraseña
    const icon = document.querySelector(".bx");                // Obtener el ícono que cambia la visibilidad

    // Verificar si ambos elementos existen antes de añadir el evento
    if (contra && icon) {
        //  evento de click al ícono
        icon.addEventListener("click", () => {
            // Alternar entre "password" y "text" para mostrar/ocultar la contraseña
            if (contra.type === "password") {
                contra.type = "text";  // Cambiar a texto para mostrar la contraseña
                icon.classList.remove('bx-show-alt');  // Cambiar el ícono a "mostrar"
                icon.classList.add('bx-hide');         // Cambiar el ícono a "ocultar"
            } else {
                contra.type = "password";  // Cambiar a tipo "password" para ocultar la contraseña
                icon.classList.add('bx-show-alt'); 
                icon.classList.remove('bx-hide'); 
            }
        });
    } else {
        console.error("No se encontró el campo de contraseña o el ícono de visibilidad.");
    }
});

const contra = document.getElementById("contrasenia"),
icon = document.querySelector(".bx");

icon.addEventListener("click", e => {
    if (contra.type === "password"){
        contra.type = "text";
    } else{
        contra.type = "password"
    }
})
 
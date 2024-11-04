const contra = document.getElementById("contrasenia"),
icon = document.querySelector(".bx");

icon.addEventListener("click", e => {
    if (contra.type === "password"){
        contra.type = "text";
        icon.classList.remove('bx-show-alt')
        icon.classList.add('bx-hide')
    } else{
        contra.type = "password";
        icon.classList.add('bx-show-alt')
        icon.classList.remove('bx-hide')
    }
})
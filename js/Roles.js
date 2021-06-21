const formRoles = document.querySelector("#formRoles");
const opcion = document.querySelector("#opcion");
const arrayBtnEliminar = document.querySelectorAll(".btnEliminar");
const tablaRoles = document.querySelector("#tablaRoles");

document.addEventListener("DOMContentLoaded", () => {
    formRoles.addEventListener("submit", guardarRol);
    tablaRoles.addEventListener("click", eliminarRol);
})

//Funcion insertar o actualizar un rol
function guardarRol(e) {
    e.preventDefault();
    const rol = document.querySelector("#rol").value;

    //Gaurda los datos dentro de un objeto
    const data = new FormData(formRoles);

    //Si viene vacio informamos problema y corta la ejecucion
    if (rol.trim() === '') {
        alert("Debe llenar los campos");
        return;
    }

    //Si la opcion es insertar rol
    const xhr = new XMLHttpRequest();

    xhr.open("POST", formRoles.getAttribute("action"));

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);

            if (respuesta.message == "exito insert") {
                location.reload();
            } else if (respuesta.message == "exito update") {
                location.href = "Roles.php";
            } else {
                alert("Hubo un error, intente nuevamente");
            }
        }
    }
    xhr.send(data);
}

//Funcion eliminar un rol
function eliminarRol(e) {

    for (let i = 0; i < arrayBtnEliminar.length; i++) {
        if (e.target === arrayBtnEliminar[i]) {
            const idRol = arrayBtnEliminar[i].getAttribute("data-id");
            
            const xhr = new XMLHttpRequest();

            xhr.open("GET",formRoles.getAttribute("action")+"?idRol="+idRol+"&opcion=3");

            xhr.onload = function(){
                if(xhr.status === 200){
                    const respuesta = JSON.parse(xhr.responseText);
                    if(respuesta.message === "exito delete"){
                        arrayBtnEliminar[i].parentElement.parentElement.remove();   //Elimina el registro de la tabla 
                    }
                }
            }
            xhr.send();
        }
    }
}
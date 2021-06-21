const formRolesUsuario = document.querySelector("#formRolesUsuario");
const opcion = document.querySelector("#opcion");
const arrayBtnEliminar = document.querySelectorAll(".btnEliminar");
const tablaRolesUsuarios = document.querySelector("#tablaRolesUsuarios");

document.addEventListener("DOMContentLoaded", () => {
    formRolesUsuario.addEventListener("submit", guardarRol);
    tablaRolesUsuarios.addEventListener("click", eliminarRol);
})

//Funcion insertar o actualizar un rol
function guardarRol(e) {
    e.preventDefault();
    const idRol = document.querySelector("#idRol").value;
    const idUsuario = document.querySelector("#idUsuario").value;

    //Gaurda los datos dentro de un objeto
    const data = new FormData(formRolesUsuario);

    //Si viene vacio informamos problema y corta la ejecucion
    if (idRol == 0 && idUsuario == 0) {
        alert("Debe llenar los campos");
        return;
    }

    //Si la opcion es insertar rol
    const xhr = new XMLHttpRequest();

    xhr.open("POST", formRolesUsuario.getAttribute("action"));

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);

            if (respuesta.message == "exito insert") {
                location.reload();
            } else if (respuesta.message == "exito update") {
                location.href = "AsignarRoles.php";
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
            const idRolUsu = arrayBtnEliminar[i].getAttribute("data-id");
            
            const xhr = new XMLHttpRequest();

            xhr.open("GET",formRolesUsuario.getAttribute("action")+"?idRolUsu="+idRolUsu+"&opcion=3");

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
const formUsers = document.querySelector("#formUsers");
const opcion = document.querySelector("#opcion");
const arrayBtnEliminar = document.querySelectorAll(".btnEliminar");
const tablaUsers = document.querySelector("#tablaUsers");

document.addEventListener("DOMContentLoaded", () => {
    formUsers.addEventListener("submit", guardarUsuario);
    tablaUsers.addEventListener("click", eliminarUsuario);
})

//Funcion insertar o actualizar un rol
function guardarUsuario(e) {
    e.preventDefault();
    const nombre = document.querySelector("#usuarioNomApe").value;
    const telefono = document.querySelector("#usuarioTelefono").value;
    const correo = document.querySelector("#usuarioCorreo").value;

    //Gaurda los datos dentro de un objeto
    const data = new FormData(formUsers);

    //Si viene vacio informamos problema y corta la ejecucion
    if (nombre.trim() === '' || telefono.trim() === '' || correo.trim() === '') {
        alert("Debe llenar los campos");
        return;
    }

    //Si la opcion es insertar rol
    const xhr = new XMLHttpRequest();

    xhr.open("POST", formUsers.getAttribute("action"));

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);

            if (respuesta.message == "exito insert") {
                location.reload();
            } else if (respuesta.message == "exito update") {
                location.href = "Usuarios.php";
            } else {
                alert("Hubo un error, intente nuevamente");
            }
        }
    }
    xhr.send(data);
}

//Funcion eliminar un rol
function eliminarUsuario(e) {

    for (let i = 0; i < arrayBtnEliminar.length; i++) {
        if (e.target === arrayBtnEliminar[i]) {
            const idUsuario = arrayBtnEliminar[i].getAttribute("data-id");
            
            const xhr = new XMLHttpRequest();

            xhr.open("GET",formUsers.getAttribute("action")+"?idUsuario="+idUsuario+"&opcion=3");

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
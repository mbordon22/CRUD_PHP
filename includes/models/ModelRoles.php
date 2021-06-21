<?php
require_once("../functions/Conexion.php");
require_once("../functions/Funciones.php");

//Gurdamos los datos recibidos en variables
$rol = isset($_REQUEST['rol']) ? $_REQUEST['rol'] : '';
$idRol = isset($_REQUEST['idRol']) ? $_REQUEST['idRol'] : '';
$opcion = $_REQUEST['opcion'];

if ($opcion == 1) {

    //Ejecución del INSERT
    try {

        $stmt = $conn->prepare(" INSERT INTO roles (rol) VALUE (?) ");
        $stmt->bind_param("s", $rol);

        $stmt->execute();

        if ($stmt->affected_rows) {
            $response = array(
                "message" => "exito insert",
                "id" => $stmt->insert_id
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $response = array(
            "message" => "error",
            "error" =>  $e->getMessage()
        );
    }

    die(json_encode($response));    //Envia respuesta por json

} elseif ($opcion == 2) {

    //Ejecución del UPDATE
    try {

        $stmt = $conn->prepare(" UPDATE roles SET rol = ? WHERE idRol = ? ");
        $stmt->bind_param("si", $rol, $idRol);

        $stmt->execute();

        if ($stmt->affected_rows) {
            $response = array(
                "message" => "exito update",
                "id" => $stmt->insert_id
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $response = array(
            "message" => "error",
            "error" =>  $e->getMessage()
        );
    }

    die(json_encode($response));    //Envia respuesta por json

} elseif ($opcion == 3) {

    //elimina todos los datos de la tabla roles_usuarios con el idRol indicado
    if(!eliminarPorRol($idRol)){
        $response = array(
            "message" => "Error"
        );
        die(json_encode($response));
    }


    //Ejecución del DELETE
    try {
        $stmt = $conn->prepare(" DELETE FROM roles WHERE idRol = ? ");
        $stmt->bind_param("i", $idRol);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array(
                "message" => "exito delete",
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $response = array(
            "message" => $e->getMessage()
        );
    }

    die(json_encode($response));    //Envia respuesta por json
}

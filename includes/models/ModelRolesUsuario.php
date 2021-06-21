<?php
require_once("../functions/Conexion.php");

//Gurdamos los datos recibidos en variables
$idUsuario = isset($_REQUEST['idUsuario']) ? $_REQUEST['idUsuario'] : '';
$idRol = isset($_REQUEST['idRol']) ? $_REQUEST['idRol'] : '';
$idRolUsu = isset($_REQUEST['idRolUsu']) ? $_REQUEST['idRolUsu'] : '';
$opcion = $_REQUEST['opcion'];

if ($opcion == 1) {

    //Ejecucion del INSERT
    try {

        $stmt = $conn->prepare(" INSERT INTO  rol_usuario (idUsuario, idRol) VALUE (?,?) ");
        $stmt->bind_param("ii", $idUsuario, $idRol);

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

    //Ejecucion del UPDATE
    try {

        $stmt = $conn->prepare(" UPDATE rol_usuario SET idUsuario = ?, idRol = ? WHERE idRolUsu = ? ");
        $stmt->bind_param("iii", $idUsuario, $idRol, $idRolUsu);

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

    //Ejecucion del DELETE
    try {
        $stmt = $conn->prepare(" DELETE FROM rol_usuario WHERE idRolUsu = ? ");
        $stmt->bind_param("i", $idRolUsu);

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

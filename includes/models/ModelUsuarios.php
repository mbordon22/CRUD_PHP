<?php
require_once("../functions/Conexion.php");
require_once("../functions/Funciones.php");

//Gurdamos los datos recibidos en variables
$usuarioNomApe = isset($_REQUEST['usuarioNomApe']) ? $_REQUEST['usuarioNomApe'] : '';
$usuarioTelefono = isset($_REQUEST['usuarioTelefono']) ? $_REQUEST['usuarioTelefono'] : '';
$usuarioCorreo = isset($_REQUEST['usuarioCorreo']) ? $_REQUEST['usuarioCorreo'] : '';
$idUsuario = isset($_REQUEST['idUsuario']) ? $_REQUEST['idUsuario'] : '';
$opcion = $_REQUEST['opcion'];


//Direccion en donde vamos a guardar las imagenes.
$directorio = "../../img/usuarios/";

//Verificar que el directorio exista, de no ser así crearlo.
if (!file_exists($directorio)) {
    mkdir($directorio, 0777, true);
}

if ($opcion == 1) {

    //Arma el nombre con el que va a guardar el archivo
    $nombreArchivo = microtime();
    $extension = pathinfo($_FILES["usuarioImagen"]['name'], PATHINFO_EXTENSION);
    $usuarioImagen = $nombreArchivo . "." . $extension;

    //Movemos el archivo de al ubicación temporal al directorio especificado
    if (move_uploaded_file($_FILES["usuarioImagen"]["tmp_name"], $directorio . $usuarioImagen)) {

        $usuarioImagen = $usuarioImagen;
        $imagen_resultado = "Se subio correctamente";
    } else {

        $response = array(
            "message" => "Error al crear la imagen"
        );
        die(json_encode($response));
    }


    //Ejecucion del INSERT
    try {

        $stmt = $conn->prepare(" INSERT INTO usuarios (usuarioNomApe, usuarioTelefono, usuarioCorreo, usuarioImagen) VALUE (?,?,?,?) ");
        $stmt->bind_param("ssss", $usuarioNomApe, $usuarioTelefono, $usuarioCorreo, $usuarioImagen);

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

    die(json_encode($response));    //Envia la respuesta por json

} elseif ($opcion == 2) {

    //Obtiene el nombre de la imagen ya guardada en la bd
    $datosUsuario = traerUnUsuario($idUsuario);
    $imagenAnterior = $datosUsuario['usuarioImagen'];

    ($_FILES['usuarioImagen']['name'] == '') ? $hayimagen = false : $hayimagen = true;  //Controla si viene una imagen para actualizar o no

    if ($hayimagen) {

        //Arma el nombre con el que va a guardar el archivo
        $nombreArchivo = microtime();
        $extension = pathinfo($_FILES["usuarioImagen"]['name'], PATHINFO_EXTENSION);
        $usuarioImagen = $nombreArchivo . "." . $extension;

        //Movemos el archivo de al ubicación temporal al directorio especificado
        if (move_uploaded_file($_FILES["usuarioImagen"]["tmp_name"], $directorio . $usuarioImagen)) {

            $usuarioImagen = $usuarioImagen;
            $imagen_resultado = "Se subio correctamente";
            unlink($directorio . $imagenAnterior); //Elimina la imagen anterior del servidor
        } else {

            $response = array(
                "message" => "Error al crear la imagen"
            );
            die(json_encode($response));
        }
    }

    //Ejecucion del UPDATE
    try {

        if (!$hayimagen) {
            $stmt = $conn->prepare(" UPDATE usuarios SET usuarioNomApe = ?, usuarioTelefono = ?, usuarioCorreo = ? WHERE idUsuario = ? ");
            $stmt->bind_param("sssi", $usuarioNomApe, $usuarioTelefono, $usuarioCorreo, $idUsuario);
        } else {
            $stmt = $conn->prepare(" UPDATE usuarios SET usuarioNomApe = ?, usuarioTelefono = ?, usuarioCorreo = ?, usuarioImagen = ? WHERE idUsuario = ? ");
            $stmt->bind_param("ssssi", $usuarioNomApe, $usuarioTelefono, $usuarioCorreo, $usuarioImagen, $idUsuario);
        }

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

    die(json_encode($response));    //Envia la respuesta por json
    
} elseif ($opcion == 3) {

    //elimina todos los datos de la tabla roles_usuarios con el idUsuario indicado
    if(!eliminarPorUsuario($idUsuario)){
        $response = array(
            "message" => "Error"
        );
        die(json_encode($response));
    }

    //Obtiene el nombre de la imagen ya guardada en la bd
    $datosUsuario = traerUnUsuario($idUsuario);
    $imagenAnterior = $datosUsuario['usuarioImagen'];

    //Ejecucion del DELETE
    try {
        $stmt = $conn->prepare(" DELETE FROM usuarios WHERE idUsuario = ? ");
        $stmt->bind_param("i", $idUsuario);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array(
                "message" => "exito delete",
            );
            unlink($directorio.$imagenAnterior);    //Elimina la imagen del servidor
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $response = array(
            "message" => $e->getMessage()
        );
    }

    die(json_encode($response));    //Envia la respuesta por json
}

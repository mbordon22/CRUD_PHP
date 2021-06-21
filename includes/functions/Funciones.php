<?php

function traerTodosRoles()
{
    //traemos todos los campos que esten cargados
    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" SELECT * FROM roles ");
        $stmt->execute();

        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function traerUnRol($id)
{
    //traemos todos los campos que esten cargados
    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" SELECT * FROM roles WHERE idRol = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result;

        
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function traerTodosUsuarios()
{
    //traemos todos los campos que esten cargados
    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" SELECT * FROM usuarios ");
        $stmt->execute();

        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function traerUnUsuario($id)
{
    //traemos todos los campos que esten cargados
    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" SELECT * FROM usuarios WHERE idUsuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result;

        
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function traerTodosRolesUsuarios()
{
    //traemos todos los campos que esten cargados
    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" SELECT * FROM rol_usuario INNER JOIN usuarios ON rol_usuario.idUsuario = usuarios.idUsuario INNER JOIN roles ON rol_usuario.idRol = roles.idRol ");
        $stmt->execute();

        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

function traerUnRolUsu($id)
{
    //traemos todos los campos que esten cargados
    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" SELECT * FROM rol_usuario INNER JOIN usuarios ON rol_usuario.idUsuario = usuarios.idUsuario INNER JOIN roles ON rol_usuario.idRol = roles.idRol WHERE rol_usuario.idRolUsu = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result;

        
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

//Elimina todos los datos de la tabla rol_usuarios que tengan un idRol especifico
function eliminarPorRol($id){

    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" DELETE FROM rol_usuario WHERE idRol = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->affected_rows;
        return $result;

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

//Elimina todos los datos de la tabla rol_usuarios que tengan un idUsuario especifico
function eliminarPorUsuario($id){

    try {
        include("Conexion.php");

        $stmt = $conn->prepare(" DELETE FROM rol_usuario WHERE idUsuario = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->affected_rows;
        return $result;
        
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
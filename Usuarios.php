<?php 
require_once("includes/functions/Funciones.php");
$opcion = 1;

//Si viene un id por la url entra a buscar los datos del id
if (isset($_REQUEST["idUsuario"])) {
    $usuarioSeleccionado = traerUnUsuario($_REQUEST['idUsuario']);

    $idUsuario = $usuarioSeleccionado['idUsuario'];
    $usuarioNomApe = $usuarioSeleccionado['usuarioNomApe'];
    $usuarioTelefono = $usuarioSeleccionado['usuarioTelefono'];
    $usuarioCorreo = $usuarioSeleccionado['usuarioCorreo'];
    $opcion = 2;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: #e1e1e1;
    }
    .imgUsuario{
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
</style>

<body>
    <?php require_once("includes/layouts/nav.php") ?>
    <div class="container">
        <div class="row justify-content-md-between">
            <!-- Titulo -->
            <div class="col-12 text-center my-5">
                <h3>Usuarios</h3>
            </div>

            <!-- Formulario -->
            <div class="col-12 mb-5">
                <form action="includes/models/ModelUsuarios.php" method="POST" id="formUsers">
                    <div class="row justify-content-center mb-3">
                        <div class="form-group col-8 col-md-3">
                            <label for="usuarioNomApe">Apellido y Nombre:</label>
                            <input type="text" id="usuarioNomApe" name="usuarioNomApe" class="form-control" value="<?php echo isset($usuarioNomApe)?trim($usuarioNomApe):''; ?>" autofocus>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="form-group col-8 col-md-3">
                            <label for="usuarioTelefono">Teléfono:</label>
                            <input type="number" id="usuarioTelefono" name="usuarioTelefono" class="form-control" value="<?php echo isset($usuarioTelefono)?trim($usuarioTelefono):'';?>">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-8 col-md-3">
                            <label for="usuarioCorreo">Correo:</label>
                            <input type="email" id="usuarioCorreo" name="usuarioCorreo" class="form-control" value="<?php echo isset($usuarioCorreo)?trim($usuarioCorreo): ''; ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-8 col-md-3">
                            <label for="usuarioImagen">Foto:</label>
                            <input type="file" id="usuarioImagen" name="usuarioImagen" class="form-control">
                        </div>
                    </div>
                    <div class="row my-3 justify-content-center">
                        <div class="form-group col-8 col-md-3 d-flex justify-content-end">
                            <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo isset($idUsuario) ? $idUsuario : '';?>">
                            <input type="hidden" id="opcion" name="opcion" value="<?php echo $opcion ?>">
                            <a href="Usuarios.php" class="btn btn-danger">Limpiar</a>
                            <input type="submit" id="btnSubmit" class="btn btn-primary" value="<?php echo $opcion == 1 ? 'Crear' : 'Actualizar'; ?>">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla -->
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 my-5 table-responsive justify-content-center">
                        <table class="table table-hover table-bordered border-dark" id="tablaUsers">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Apellido y Nombre</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = traerTodosUsuarios();
                                while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><img src="img/usuarios/<?php echo $row['usuarioImagen'];?>" class="imgUsuario"></td>
                                        <td><?php echo $row["usuarioNomApe"]; ?></td>
                                        <td><?php echo $row["usuarioTelefono"]; ?></td>
                                        <td><?php echo $row["usuarioCorreo"]; ?></td>
                                        <td>
                                            <a href="Usuarios.php?idUsuario=<?php echo $row['idUsuario']; ?>" class="btn btn-success">Editar</a>
                                            <button data-id="<?php echo $row['idUsuario']; ?>" class="btn btn-danger btnEliminar">Borrar</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="js/Usuarios.js"></script>
</body>

</html>
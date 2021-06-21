<?php
require_once("includes/functions/Funciones.php");
$opcion = 1;

//Si viene un id por la url entra a buscar los datos del id
if (isset($_REQUEST["idRol"])) {
    $rolSeleccionado = traerUnRol($_REQUEST['idRol']);

    $idRol = $rolSeleccionado['idRol'];
    $rol = $rolSeleccionado['rol'];

    $opcion = 2;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <!-- CDN CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        body {
            background-color: #e1e1e1;
        }
    </style>
</head>

<body>
    <?php require_once("includes/layouts/nav.php") ?>
    <div class="container">
        <div class="row justify-content-md-between">
            <!-- Titulo -->
            <div class="col-12 text-center my-5">
                <h3>Roles</h3>
            </div>

            <!-- Formulario -->
            <div class="col-12 mb-5">
                <form action="includes/models/ModelRoles.php" method="POST" id="formRoles">
                    <div class="row justify-content-center">
                        <div class="form-group col-8 col-md-3">
                            <label for="rol">Rol:</label>
                            <input type="text" id="rol" name="rol" class="form-control" value="<?php echo isset($rol) ? $rol : ''; ?>" autofocus>
                        </div>
                    </div>
                    <div class="row my-3 justify-content-center">
                        <div class="form-group col-8 col-md-3 d-flex justify-content-end">
                            <input type="hidden" id="idRol" name="idRol" value="<?php echo isset($idRol) ? $idRol : '';?>">
                            <input type="hidden" id="opcion" name="opcion" value="<?php echo $opcion ?>">
                            <a href="Roles.php" class="btn btn-danger">Limpiar</a>
                            <input type="submit" id="btnSubmit" class="btn btn-primary" value="<?php echo $opcion == 1 ? 'Crear' : 'Actualizar'; ?>">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla -->
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 my-5 table-responsive justify-content-center">
                        <table class="table table-hover table-bordered border-dark" id="tablaRoles">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = traerTodosRoles();
                                while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><strong><?php echo $row["idRol"]; ?><strong></td>
                                        <td><?php echo $row["rol"]; ?></td>
                                        <td>
                                            <a href="Roles.php?idRol=<?php echo $row['idRol']; ?>" class="btn btn-success">Editar</a>
                                            <button data-id="<?php echo $row['idRol']; ?>" class="btn btn-danger btnEliminar">Borrar</button>
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

    <!-- CDN JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="js/Roles.js"></script>
</body>

</html>
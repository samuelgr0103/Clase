<?php
require '../../include/funciones.php';
$auth = estaAutenticado();
$usuario = $_SESSION['usuario'];
if (!$auth) {
    header('location: /');
}
if ($usuario !== 'samuelgr62@gmail.com') {
    header('location: /');
}

//Importar la conexion
require '../../include/config/database.php';
$db = conectarDB();
//Escribir en el query

//consultar la BD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo=$_POST['id'];
    $leer=fopen("datos.txt","r");
    $escribir=fopen("temp.txt","a+");
    while(!feof($leer)){					
        $id=fgets($leer);
        $nombre=fgets($leer);
        $apellidos=fgets($leer);
        $edad=fgets($leer);
        $puesto=fgets($leer);
        if($codigo!=$id){						
            fputs($escribir,$id);
            fputs($escribir,$nombre);
            fputs($escribir,$apellidos);
            fputs($escribir,$edad);
            fputs($escribir,$puesto);
        }
    }
    fclose($leer);
    fclose($escribir);
    if(rename("temp.txt","datos.txt")){}
       // echo "Registro eliminado correctamente!!!!!<br>";

}

incluirTemplates('header');
?>

<main class="contenedor">
    <h1 class="centrar-texto">Baristas</h1>
    <div class="botones-titulos">
        <a href="/admin/index.php" class="boton boton--cafe">Regresar</a>
        <a href="/admin/baristas/insertarVarista.php" class="boton boton--cafe">Agregar</a>

    </div>

    <table class="cursos">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $mostrar = fopen('datos.txt', 'r');
            while (!feof($mostrar)) {
                $id = fgets($mostrar);
                $nombre = fgets($mostrar);
                $apellidos = fgets($mostrar);
                $edad = fgets($mostrar);
                $puesto = fgets($mostrar);
                if ($id != "") {
            ?> <tr>

                        <td> <?php echo $id; ?></td>
                        <td> <?php echo $nombre; ?></td>
                        <td> <?php echo $apellidos; ?></td>
                        <td> <?php echo $edad; ?></td>
                        <td> <?php echo $puesto; ?></td>
                        <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" class="boton-negro-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/baristas/actualizarVarista.php?id=<?php echo $id; ?>">Actializar</a>
                    </td>
                    </tr>

            <?php
                }
            }
            ?>

            <!--Mostrar Resultados-->

        </tbody>
    </table>

</main>
<?php

//Cerrar la conexion
mysqli_close($db);
incluirTemplates('footer');
?>
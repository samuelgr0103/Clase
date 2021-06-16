<?php
$errores = [];
//Arreglo de estados
$estados = ['Guerrero', 'Hidalgo', 'México', 'Querétaro', 'Morelos'];

$nombre = '';
$codigo = '';
$mensaje = '';
$imagen = '';
$NoGusta = 0;
$gusta = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //    echo "<pre>";
    //    var_dump($_POST);
    //    var_dump($_FILES);
    //    echo "</pre>";
    //    exit;

    $nombre = $_POST['nombre'];
    $mensaje = $_POST['mensaje'];
    $codigo = (int)$_POST['codigo'];
    $imagen = $_FILES['imagen'];
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }

    if (empty($errores)) {
        $carpetaImagenes = 'imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }
        //generando nombre aleatorio
        $nombreImagem = md5(uniqid(rand(), true)) . '.jpg';

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagem);

        //*Sibida de archivos */
        $leer = fopen("datos.txt", "r");
        $flag = true;
        while (!feof($leer)) {
            $claveid = fgets($leer);
            $clavenom = fgets($leer);
            $claveape = fgets($leer);
            $claveeda = fgets($leer);
            $clavesi = fgets($leer);
            $claveno = fgets($leer);

            if ($codigo == $claveid) {
                echo "ERROR.....El registro ya existe";
                $flag = false;
                break;
            }
        }
        fclose($leer);
        if ($flag) {
            $guardar = fopen('datos.txt', 'a+');
            fputs($guardar, $codigo . "\n");
            fputs($guardar, $nombre . "\n");
            fputs($guardar, $mensaje . "\n");
            fputs($guardar, $nombreImagem . "\n");
            fputs($guardar, $gusta . "\n");
            fputs($guardar, $NoGusta . "\n");
            fclose($guardar);
            echo "Datos guardados correctamente";
            //Redireccionar al usuario
            header('Location: /');
        }
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Clase </title>
</head>

<body>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
        
            <legend>Ingresar tus datos de compra</legend>
            <label for="codigo">Codigo: </label>
            <input type="text" id="codigo" name="codigo" placeholder="Ingresa tu codigo postal" value="<?php echo $codigo ?>">
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" value="<?php echo $nombre ?>">
            <label for="imagen">Imagen del Curso: </label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <label for="mensaje">Mensaje: </label>
            <textarea class="campo__field campo__field__textarea" id="mensaje" name="mensaje" cols="30" rows="10"><?php echo $mensaje ?></textarea>
        </fieldset>
        <br>
        <input type="submit" value="Agregar" class="boton boton--secundario">
    </form>


    <?php
    $mostrar = fopen('datos.txt', 'r');
    while (!feof($mostrar)) {
        $id = fgets($mostrar);
        $nombre = fgets($mostrar);
        $apellidos = fgets($mostrar);
        $imagen = fgets($mostrar);
        $gusta = fgets($mostrar);
        $nogusta = fgets($mostrar);
        if ($id != "") {
    ?>
            <div class="mostrar">
                <div class="mensajes">
                    <div class="nombre">
                        <p><?php echo " " . $nombre; ?></p>
                        <p>  dice: </p>
                    </div>
                    <div class="mensaje">
                        <p>Mensaje</p>
                        <p><?php echo $apellidos; ?></p>
                        <a class="boton-amarillo-block" href="borrar.php?id=<?php echo $id; ?>">Eliminar</a>
                        <a class="boton-amarillo-block" href="actualizar.php?id=<?php echo $id; ?>">Actializar</a>

                    </div>
                    <div class="imagen">
                        <img src="/imagenes/<?php echo $imagen; ?>" class="imagen-tabla">
                    </div>

                    <div class="like">
                        <div>
                            <p><a href="Gustas.php?id=<?php echo $id; ?>">Me Gusta</p></a>
                            <div class="Gustar"><?php echo $gusta; ?></div>
                            <p>No me gusta</p>
                            <div class="Gustar"><?php echo $nogusta; ?></div>
                        </div>
                    </div>
                </div>

            </div>


    <?php
        }
    }
    ?>

    <!--Mostrar Resultados-->


</body>

</html>
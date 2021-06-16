<?php
$codigow = $_GET['id'];
$leer = fopen("datos.txt", "r");
while (!feof($leer)) {
    $id = fgets($leer);
    $nombres = fgets($leer);
    $apellidos = fgets($leer);
    $edad = fgets($leer);
    $puesto = fgets($leer);
    if ($codigow == $id) {
        $codigo = $id;
        $nombre = $nombres;
        $mensaje = $apellidos;
        $telefono = $edad;
        $correo = $puesto;
    }
}
fclose($leer);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $nombre = $_POST['nombre'];
    $mensaje = $_POST['mensaje'];
    $codigo = (int)$_POST['codigo'];
    $imagen = $_FILES['imagen'];
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }
    //Asignar file hacia una variables


    if (!$nombre) {
        $errores[] = "Debes añadir tu nombre";
    }
    if (!$apellido) {
        $errores[] = "Debes añadir tu apellido";
    }
    if (!$codigo) {
        $errores[] = "Debes añadir tu codigo";
    }
    if (!$telefono) {
        $errores[] = "Debes añadir tu Telefono";
    }
    if (!$correo) {
        $errores[] = "Debes añadir tu correo";
    }




    //echo "<pre>";
    //var_dump($errores);
    //echo "</pre>";
    //Resivsar que el arreglo de errores esta vacio
    if (empty($errores)) {

        $codigo = filter_var($codigo,FILTER_VALIDATE_INT);

        $leer = fopen("datos.txt", "r");
        $escribir = fopen("temp.txt", "a+");
        while (!feof($leer)) {
            $codigox = fgets($leer);
            $nombrex = fgets($leer);
            $apellidox = fgets($leer);
            $telefonox = fgets($leer);
            $correox = fgets($leer);
            $correoy = fgets($leer);
            if ($codigo != $codigox) {
                fputs($escribir, $codigox);
                fputs($escribir, $nombrex);
                fputs($escribir, $apellidox);
                fputs($escribir, $telefonox);
                fputs($escribir, $correox);
                fputs($escribir, $correoy);
            } else {
                fputs($escribir, $codigo . "\n");
                fputs($escribir, $nombre . "\n");
                fputs($escribir, $mensaje . "\n");
                fputs($escribir, $imagen . "\n");
                fputs($escribir, $correo . "\n");
                fputs($escribir, $correo . "\n");
            }
        }
        fclose($leer);
        fclose($escribir);
        if (rename("temp.txt", "datos.txt"))
            header('Location: /admin/baristas/mostrarVarista.php');
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

    <title>Document</title>
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

</body>
</html>
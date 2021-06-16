<?php
require '../../include/funciones.php';
$auth = estaAutenticado();
if (!$auth) {
    header('location: /');
}
//Conectar a la base
require '../../include/config/database.php';
$db = conectarDB();

$codigow = $_GET['id'];

//Consultar para obtener los vendedores

//Arreglo con mensajes de errores
$errores = [];


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
        $apellido = $apellidos;
        $telefono = $edad;
        $correo = $puesto;
    }
}
fclose($leer);





//Ejecutar el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    //    var_dump($_POST);
    //  echo "</pre>";
    //var_dump($_POST);
    //   exit;
    $codigo = $_POST['codigo'];

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
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
            if ($codigo != $codigox) {
                fputs($escribir, $codigox);
                fputs($escribir, $nombrex);
                fputs($escribir, $apellidox);
                fputs($escribir, $telefonox);
                fputs($escribir, $correox);
            } else {
                fputs($escribir, $codigo . "\n");
                fputs($escribir, $nombre . "\n");
                fputs($escribir, $apellido . "\n");
                fputs($escribir, $telefono . "\n");
                fputs($escribir, $correo . "\n");
            }
        }
        fclose($leer);
        fclose($escribir);
        if (rename("temp.txt", "datos.txt"))
            header('Location: /admin/baristas/mostrarVarista.php');
    }
}

incluirTemplates('header');
?>

<main class="contenedor">
    <h3 class="centrar-texto">Actualizar Barista</h3>
    <a href="../baristas/mostrarVarista.php" class="boton boton--primario">Volver</a>
    <br>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Ingresar tus datos de compra</legend>
            <label for="codigo">Codigo: </label>
            <input type="text" id="codigo"  name="codigo" placeholder="Ingresa tu codigo postal" value="<?php echo $codigo; ?>">
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" value="<?php echo $nombre; ?>">
            <label for="apellido">Apellido: </label>
            <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" value="<?php echo $apellido; ?>">
            <label for="telefono">Telefono: </label>
            <input type="text" id="telefono" name="telefono" placeholder="Ingresa tu telefono" value="<?php echo $telefono; ?>">
            <label for="correo">Correo: </label>
            <input type="email" id="correo" name="correo" placeholder="Ingresa tu correo" value="<?php echo $correo; ?>">

        </fieldset>
        <br>
        <input type="submit" value="Actualizar" class="boton boton--secundario">
    </form>
</main>
<?php
incluirTemplates('footer');
?>
<?php
require '../../include/funciones.php';
$auth = estaAutenticado();
if (!$auth) {
    header('location: /');
}
//Conectar a la base
require '../../include/config/database.php';
$db = conectarDB();

//Consultar para obtener los vendedores

//Arreglo con mensajes de errores
$errores = [];
//Arreglo de estados
$estados = ['Guerrero', 'Hidalgo', 'México', 'Querétaro', 'Morelos'];

$nombreCurso;
$precioCurso;
$descripcionCurso;
$fecha = date('Y/m/d');
$nombre = '';
$apellido = '';
$precio = '';
$descripcion = '';

//Ejecutar el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //echo "<pre>";
    //var_dump($_POST);
    //echo "</pre>";
    //var_dump($_POST);
    //exit;
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $codigo = (int)$_POST['codigo'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];
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

        //*Sibida de archivos */
        $leer = fopen("datos.txt", "r");
        $flag = true;
        while (!feof($leer)) {
            $claveid = fgets($leer);
            $clavenom = fgets($leer);
            $claveape = fgets($leer);
            $claveeda = fgets($leer);
            $clavepue = fgets($leer);
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
            fputs($guardar, $apellido . "\n");
            fputs($guardar, $telefono . "\n");
            fputs($guardar, $correo . "\n");
            fclose($guardar);
            echo "Datos guardados correctamente";
            //Redireccionar al usuario
            header('Location: /admin/baristas/mostrarVarista.php');

        }



        }
}

incluirTemplates('header');
?>

<main class="contenedor">
    <h3 class="centrar-texto">Agregar Varista</h3>
    <a href="../index.php" class="boton boton--primario">Volver</a>
    <br>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Ingresar tus datos de compra</legend>
            <label for="codigo">Codigo: </label>
            <input type="text" id="codigo" name="codigo" placeholder="Ingresa tu codigo postal" value="<?php echo $nombre ?>">
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" value="<?php echo $nombre ?>">
            <label for="apellido">Apellido: </label>
            <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" value="<?php echo $apellido ?>">
            <label for="telefono">Telefono: </label>
            <input type="text" id="telefono" name="telefono" placeholder="Ingresa tu apellido" value="">
            <label for="correo">Correo: </label>
            <input type="email" id="correo" name="correo" placeholder="Ingresa tu correo" value="">

        </fieldset>
        <br>
        <input type="submit" value="Agregar" class="boton boton--secundario">
    </form>
</main>
<?php
incluirTemplates('footer');
?>
<?php
var_dump($_GET);
$codigo=$_GET['id'];
$codigow = filter_var($codigo,FILTER_VALIDATE_INT);

$leer = fopen("datos.txt", "r");
while (!feof($leer)) {
    $id = fgets($leer);
    $nombres = fgets($leer);
    $apellidos = fgets($leer);
    $edad = fgets($leer);
    $puesto = fgets($leer);
    $nopuesto = fgets($leer);
    if ($codigow == $id) {
        $codigo = $id;
        $nombre = $nombres;
        $apellido = $apellidos;
        $telefono = $edad;
        $correo = (int)$puesto;
        $correo=$correo+1;
        $Nocorreo = $nopuesto;
    }
}
fclose($leer);


$leer = fopen("datos.txt", "r");
        $escribir = fopen("temp.txt", "a+");
        while (!feof($leer)) {
            $codigox = fgets($leer);
            $nombrex = fgets($leer);
            $apellidox = fgets($leer);
            $telefonox = fgets($leer);
            $correox = fgets($leer);
            $correoy = fgets($leer);
            if ($codigow != $codigox) {
                fputs($escribir, $codigox);
                fputs($escribir, $nombrex);
                fputs($escribir, $apellidox);
                fputs($escribir, $telefonox);
                fputs($escribir, $correox);
                fputs($escribir, $correoxy);
            } else {
                fputs($escribir, $codigow . "\n");
                fputs($escribir, $nombre );
                fputs($escribir, $apellido);
                fputs($escribir, $telefono);
                fputs($escribir, $correo . "\n");
                fputs($escribir, $Nocorreo . "\n");
            }
        }
        fclose($leer);
        fclose($escribir);
        if (rename("temp.txt", "datos.txt"))
    header('Location: /');

<?php
$codigo=$_GET['id'];
var_dump($codigo);
$leer=fopen("datos.txt","r");
$escribir=fopen("temp.txt","a+");
while(!feof($leer)){					
    $id=fgets($leer);
    $nombre=fgets($leer);
    $apellidos=fgets($leer);
    $edad=fgets($leer);
    $puesto=fgets($leer);
    $nopuesto=fgets($leer);
    if($codigo!=$id){						
        fputs($escribir,$id);
        fputs($escribir,$nombre);
        fputs($escribir,$apellidos);
        fputs($escribir,$edad);
        fputs($escribir,$puesto);
        fputs($escribir,$nopuesto);
    }
}
fclose($leer);
fclose($escribir);
if(rename("temp.txt","datos.txt")){
    header('Location: /');
}
   // echo "Registro eliminado correctamente!!!!!<br>";

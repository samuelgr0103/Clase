<?php

function conectarDB() : mysqli{
    $db=mysqli_connect('localhost','root','','lista');

    if(!$db){
        echo "No conecto";
    exit;
    }
    return $db;

}
function estaAutenticado(): bool
{
    session_start();
    $auth = $_SESSION['login'];
    if ($auth) {
        return true;
    }
    return false;
}


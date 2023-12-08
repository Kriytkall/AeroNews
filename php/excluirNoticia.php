<?php
require_once("conectarBanco.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_noticia = $_POST["id_noticia"];

    $result = deletarNoticia($id_noticia);

    echo $result;
} else {
    echo "Método inválido";
}
?>

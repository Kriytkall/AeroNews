<?php
require_once("conectarBanco.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_noticia = $_POST["id_noticia"];
    $titulo = $_POST["titulo"];
    $subtitulo = $_POST["subtitulo"];
    $imgUrl = $_POST["imgUrl"];
    $noticia = $_POST["texto"];

    $result = updateNoticia($id_noticia, $titulo, $subtitulo, $imgUrl, $noticia);

    echo $result;
} else {
    echo "Método inválido";
}

?>

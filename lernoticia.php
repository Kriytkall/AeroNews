<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/noticias.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Document</title>
</head>
<body>
    <nav>
        <p>AERO NEWS</p>
        <ul>  
            <li><a href="index.html">HOME</a></li>
            <li><a href="noticias.php">NOTÍCIAS</a></li>
            <li><a href="">CATEGORIAS</a></li>
            <li><a href="escrever.php">CONTATO</a></li>        
        </ul>
    </nav>
    <section class="centro">
    <?php
        if (isset($_GET['titulo']) && isset($_GET['subtitulo']) && isset($_GET['imagem']) && isset($_GET['texto'])) {
            $titulo = urldecode($_GET['titulo']);
            $subtitulo = urldecode($_GET['subtitulo']);
            $imagem = urldecode($_GET['imagem']);
            $texto = urldecode($_GET['texto']);

            echo "<div class='secao-noticia'>";
                echo "<p>$titulo</p>";
                echo "<div style='height: 2px; width: 200px; background-color: black; margin: 20px;'></div>";
                echo "<p>$subtitulo</p>";
            echo "</div>";
            echo "<img src='$imagem'>";
            echo "<article>";
                echo "<p>$texto</p>";
            echo "</article>";
        } else {
            echo "Parâmetros ausentes na URL.";
        }
    ?>

    </section>
</body>
</html>
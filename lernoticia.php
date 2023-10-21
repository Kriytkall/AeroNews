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
        require_once("salvar_noticia.php");

        if (isset($_GET['id_noticia'])) {
            $id_noticia = urldecode($_GET['id_noticia']);
            
            $resultados = lerNoticias($id_noticia);
            
            if ($resultados !== null) {
                foreach ($resultados as $noticia) {
                    $titulo = $noticia['nm_titulo'];
                    $subtitulo = $noticia['nm_subtitulo'];
                    $imagem = $noticia['img_noticia'];
                    $texto = $noticia['tx_noticia'];
                }
                
                echo "<div class='secao-noticia'>";
                    echo "<p>$titulo</p>";
                    echo "<div style='height: 2px; width: 200px; background-color: black; margin: 20px;'></div>";
                    echo "<p>$subtitulo</p>";
                    echo "<img src='$imagem'>";
                echo "</div>";
                echo "<article>";
                    echo "<p>$texto</p>";
                echo "</article>";
            } else {
                echo "Erro ao buscar notícias.";
            }
        } else {
            echo "Parâmetros ausentes na URL.";
        }
    ?>
    </section>
</body>
</html>
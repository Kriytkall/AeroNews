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
    <div class="contain">
        <div id="lista">
        <h1>Todas as notícias</h1>
        <?php
            require_once("salvar_noticia.php");
            $resultados = exibirTodasNoticias();
            if ($resultados !== null) {
                foreach ($resultados as $noticia) {
                    echo '<div id="coluna">';
                    echo "<p>" . $noticia['nm_titulo'] . "</p>";
                    echo "<p>" . $noticia['nm_subtitulo'] . "</p>";
                    echo "<a href='lernoticia.php?titulo=" . urlencode($noticia['nm_titulo']) . "&subtitulo=" . urlencode($noticia['nm_subtitulo']) . "&imagem=" . urlencode($noticia['img_noticia']) . "&texto=" . urlencode($noticia['tx_noticia']) ."'><img src='" . $noticia['img_noticia'] . "'></a>";
                    echo '</div>';
                }
            } else {
                echo "Erro ao buscar notícias.";
            }
        ?>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase.js"></script>
    <script src="js/storage.js"></script>
</body>
</html> 
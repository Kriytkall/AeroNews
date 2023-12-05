<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/noticias.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Document</title>
</head>
<body>
    <nav>
        <p>AERO NEWS</p>
        <ul>  
            <li><a href="home.php">HOME</a></li>
            <li><a href="listarNoticia.php">NOTÍCIAS</a></li>
            <li><a href="criarNoticia.php">POSTAGEM</a></li>
            <li><a href="../php/logout.php">Logout</a></li>            
        </ul>
    </nav>
    <div class="contain">
        <div id="lista">
            <?php
            require_once("../php/conectarBanco.php");

            // Verifica se o parâmetro "categoria" está presente na URL
            if (isset($_GET['categoria'])) {
                $categoria_id = $_GET['categoria'];

                // Obtém as notícias associadas a uma categoria específica
                $resultados = exibirNoticiasPorCategoria($categoria_id);

                if ($resultados !== null) {
                    foreach ($resultados as $noticia) {
                        echo '<div id="coluna">';
                        echo "<p>" . $noticia['nm_titulo'] . "</p>";
                        echo "<p>" . $noticia['nm_subtitulo'] . "</p>";
                        echo "<a href='lerNoticia.php?id_noticia=" . urlencode($noticia['id_noticia']) . "'><img src='" . $noticia['img_noticia'] . "'></a>";
                        echo '</div>';
                    }
                } else {
                    echo "Erro ao buscar notícias.";
                }
            } else {
                echo "Categoria não especificada.";
            }
            ?>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase.js"></script>
    <script src="../php/js/storage.js"></script>
</body>
</html> 
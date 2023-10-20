<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
    <article>
        <h1>Criar Nova Notícia</h1>

        <form id="formNoticia" onsubmit="enviarFormulario(event)" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br><br>
        
            <label for="subtitulo">Subtítulo:</label>
            <input type="text" id="subtitulo" name="subtitulo" required><br><br>
        
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem"><br><br>
        
            <label for="noticia">Notícia:</label><br>
            <textarea id="noticia" name="noticia" rows="4" cols="50" required></textarea><br><br>
        
            <button type="submit">Enviar</button>
        </form>
        
        <!-- Mensagem de resultado -->
        <div id="resultado"></div>
    </article>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase.js"></script>
    <script src="js/storage.js"></script>
</body>
</html> 
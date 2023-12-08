<?php
    require_once('verificar_autenticacao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
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
    <section class="centralizar-form">
        <div class="contain-form">
            <div class="cabecalho"></div>
                <div class="contain-form2">
                    <div class="contain-form3">
                        <form id="formNoticia" onsubmit="enviarFormulario(event)" enctype="multipart/form-data">
                            <div class="campo">
                                <label for="titulo">Título</label>
                                <input type="text" id="titulo" name="titulo" required>
                            </div>

                            <div class="campo">
                                <label for="subtitulo">Subtítulo</label>
                                <input type="text" id="subtitulo" name="subtitulo" required>
                            </div>

                            <div class="campo">
                                <label for="imagem">Imagem</label>
                                <input type="file" id="imagem" name="imagem">
                            </div>

                            <div class="campo">
                                <label for="noticia">Texto</label>
                                <textarea name="noticia" id="noticia" rows="10" cols="50"></textarea>
                            </div>


                            <label class="checkbox1">
                                <input type="checkbox" name="categorias[]" value="1"> AVIAÇÃO COMERCIAL
                            </label>

                            <label class="checkbox1">
                                <input type="checkbox" name="categorias[]" value="2"> AVIAÇÃO MILITAR
                            </label>

                            <label class="checkbox1">
                                <input type="checkbox" name="categorias[]" value="3"> TECNOLOGIA AERO
                            </label>
                        
                            <input class="botao-enviar" type="submit" value="Enviar">
                        </form>
                    </div>
                </div>      
            </div>
        </div>
    </section>
    <script src="../js/resetForm.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase.js"></script>
    <script src="../js/storage.js"></script>
</body>
</html> 
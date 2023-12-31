<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/noticias.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Visualizar Notícia</title>
    <style>
        .editavel {
            border: 1px solid transparent;
            padding: 5px;
            margin: 5px 0;
        }
    </style>
    <script>
        function habilitarEdicao() {
            var camposEditaveis = document.querySelectorAll('.editavel');
            camposEditaveis.forEach(function (campo) {
                campo.contentEditable = true;
                campo.style.border = '1px solid #000';
            });
        }
    </script>
    
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
    <section class="centro">
        <?php
            require_once("../php/conectarBanco.php");

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
                    echo "<p class='editavel' id='titulo'>$titulo</p>";
                    echo "<div style='height: 2px; width: 200px; background-color: black; margin: 20px;'></div>";
                    echo "<p class='editavel' id='subtitulo'>$subtitulo</p>";
                    echo "<img src='$imagem'>";
                    echo "</div>";
                    echo "<article>";
                    echo "<p class='editavel' id='texto'>$texto</p>";
                    echo "</article>";
                } else {
                    echo "Erro ao buscar notícias.";
                }
            } else {
                echo "Parâmetros ausentes na URL.";
            }
        ?>

        <input type="hidden" id="imagemAtual" value="<?php echo $imagem; ?>">

        <div class="botoes">
            <button class="botao" onclick="habilitarEdicao()">Editar</button>
            <button id="botaoSalvar" class="botao" onclick="atualizarNoticia()">Salvar</button>
            <button class="botao" onclick="excluirNoticia()">Excluir</button>
        </div>
    </section>


        <script>
            function atualizarNoticia() {
                var id_noticia = <?php echo json_encode($id_noticia); ?>;
                var titulo = document.getElementById('titulo').innerText;
                var subtitulo = document.getElementById('subtitulo').innerText;
                var texto = document.getElementById('texto').innerText;
                var imagemAtual = document.getElementById('imagemAtual').value;

                enviarDadosAoServidor(id_noticia, titulo, subtitulo, texto, imagemAtual);

                desativarEdicao();
            }

            function desativarEdicao() {
                var camposEditaveis = document.querySelectorAll('.editavel');
                camposEditaveis.forEach(function (campo) {
                    campo.contentEditable = false;
                    campo.style.border = 'none';
                });
            }

            function enviarDadosAoServidor(id_noticia, titulo, subtitulo, texto, imagemAtual) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "atualizarNoticia.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                    }
                };

                var params = "id_noticia=" + id_noticia +
                            "&titulo=" + encodeURIComponent(titulo) +
                            "&subtitulo=" + encodeURIComponent(subtitulo) +
                            "&texto=" + encodeURIComponent(texto) +
                            "&imgUrl=" + encodeURIComponent(imagemAtual);
                xhr.send(params);
            }

            function excluirNoticia() {
                var confirmaExclusao = confirm("Tem certeza que deseja excluir esta notícia?");
                
                if (confirmaExclusao) {
                    var id_noticia = <?php echo json_encode($id_noticia); ?>;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "excluirNoticia.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.responseText);
                            window.location.href = "home.php";
                        }
                    };
                    var params = "id_noticia=" + id_noticia;
                    xhr.send(params);
                }
            }
        </script>


</body>
</html>

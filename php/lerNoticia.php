<!-- lerNoticia.php -->
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
            border: 1px solid transparent; /* Esconde a borda quando não está em modo de edição */
            padding: 5px;
            margin: 5px 0;
        }

        .editavel:hover {
            background-color: #f5f5f5; /* Adapte conforme necessário */
        }
    </style>
    <script>
        function habilitarEdicao() {
            var camposEditaveis = document.querySelectorAll('.editavel');
            camposEditaveis.forEach(function (campo) {
                campo.contentEditable = true;
                campo.style.border = '1px solid #000'; // Adapte conforme necessário
            });
        }

        function atualizarNoticia() {
            // Coletar os dados editados
            var titulo = document.getElementById('titulo').innerText;
            var subtitulo = document.getElementById('subtitulo').innerText;
            var texto = document.getElementById('texto').innerText;

            // Aqui você deve enviar os dados para o servidor (via Ajax ou formulário)
            // Pode chamar uma função como enviarDadosAoServidor(titulo, subtitulo, texto);
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

        <!-- Adicione um campo oculto para armazenar o valor atual da imagem -->
        <input type="hidden" id="imagemAtual" value="<?php echo $imagem; ?>">

        <button onclick="habilitarEdicao()">Editar</button>
        <button onclick="atualizarNoticia()">Salvar</button>
    </section>
        <script>
        function atualizarNoticia() {
            // Coletar os dados editados
            var id_noticia = <?php echo json_encode($id_noticia); ?>;
            var titulo = document.getElementById('titulo').innerText;
            var subtitulo = document.getElementById('subtitulo').innerText;
            var texto = document.getElementById('texto').innerText;
            
            // Obter a imagem atual do campo oculto
            var imagemAtual = document.getElementById('imagemAtual').value;

            // Aqui você deve enviar os dados para o servidor (via Ajax ou formulário)
            // Pode chamar uma função como enviarDadosAoServidor(titulo, subtitulo, texto);

            enviarDadosAoServidor(id_noticia, titulo, subtitulo, texto, imagemAtual);
        }

        // Adicione esta função para enviar dados ao servidor
        function enviarDadosAoServidor(id_noticia, titulo, subtitulo, texto, imagemAtual) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "atualizarNoticia.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Exibir a resposta do servidor (pode ser um alert, console.log, etc.)
                    console.log(xhr.responseText);
                }
            };

            // Construir os dados a serem enviados
            var params = "id_noticia=" + id_noticia +
                        "&titulo=" + encodeURIComponent(titulo) +
                        "&subtitulo=" + encodeURIComponent(subtitulo) +
                        "&texto=" + encodeURIComponent(texto) +
                        "&imgUrl=" + encodeURIComponent(imagemAtual); // Use imagemAtual aqui

            // Enviar os dados
            xhr.send(params);
        }
    </script>


</body>
</html>

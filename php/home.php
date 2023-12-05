<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <nav>
        <p>AERO NEWS</p>
        <ul>  
            <li><a href="home.php">HOME</a></li>
            <li><a href="../php/listarNoticia.php">NOTÍCIAS</a></li>
            <?php
                $isAdmin = true;
            ?>
            <!-- Se o usuário for um administrador, exibir o botão de postagem -->
            <?php if ($isAdmin): ?>
                <li><a href="../php/criarNoticia.php">POSTAGEM</a></li>
            <?php endif; ?>
            <li><a href="../php/logout.php">Logout</a></li>   
        </ul>
    </nav>
    <header>
        <section>
            <p>Explore as últimas notícias e descubra o fascinante mundo da aviação no Aero News!</p>
            <button>Explorar</button>
        </section>      
    </header>
    <section class="container-categoria">
        <div class="box-categoria">
            <div class="categoria">
                <a href="categoria.php?categoria=1" id="categoria-1">
                    <div class="icon-categoria">
                        <span class="material-symbols-outlined">
                            flight
                        </span>
                    </div>
                </a>
                <p>AVIAÇÃO COMERCIAL</p>
                <p>Novidades nas companhias aéreas, rotas e aeronaves que estão transformando a forma como voamos.</p>
            </div>
            <div class="categoria">
                <a href="categoria.php?categoria=3" id="categoria-3">
                    <div class="icon-categoria">
                        <span class="material-symbols-outlined">
                            biotech
                        </span>
                    </div>
                </a>
                <p>TECNOLOGIA AERO</p>
                <p>Inovações em aeronaves, drones e tecnologia aeroespacial que estão moldando o futuro da aviação.</p>
            </div>
            <div class="categoria">
                <a href="categoria.php?categoria=2" id="categoria-2">
                    <div class="icon-categoria">
                        <span class="material-symbols-outlined">
                            military_tech
                        </span>
                    </div>
                </a>
                <p>AVIAÇÃO MILITAR</p>
                <p>Notícias e desenvolvimentos em aeronaves de combate e estratégias de defesa ao redor do mundo.</p>
            </div>
        </div>
    </section>
    
    <section class="noticia-principal">
        <p>BRASIL RECEBE PRIMEIROS CAÇAS F-39 GRIPEN</p>
        <div style="height: 2px; width: 200px; background-color: black; margin: 20px;"></div>
        <p>Em um marco histórico para a defesa aérea do Brasil, o país recebeu oficialmente os primeiros caças F-39 Gripen, fortalecendo sua capacidade de defesa e colocando o Brasil na vanguarda da aviação militar.</p>
        <a href="../pages/noticia-principal.html">
            <div class="imagem"></div>
        </a>
    </section>
    
    <section class="container-noticias-secundarias">
        <div class="noticias-secundarias">
            <div class="bloco-noticia">
                <div class="descricao">
                    <p>DARK STAR DEVENDADO</p>
                    <div style="height: 2px; width: 80px; background-color: black; margin: 10px;"></div>
                    <p>Descubra os mistérios cósmicos por trás do fenômeno conhecido como "Dark Star".</p>
                    <button>ver mais</button>
                </div>
                <div class="imagem" style="background-image: url('../imagens/darkstar.png');"></div>
            </div>
            <div class="bloco-noticia">
                <div class="descricao">
                    <p>SURPRENDENTE SU-75</p>
                    <div style="height: 2px; width: 80px; background-color: black; margin: 10px;"></div>
                    <p>O poderoso caça revela sua superioridade e tecnologia avançada de 5° geração.</p>
                    <button>ver mais</button>
                </div>
                <div class="imagem" style="background-image: url('../imagens/checkmate.png');"></div>
            </div>
            <div class="bloco-noticia">
                <div class="descricao">
                    <p>SU-57 MORTAL E FURTIVO</p>
                    <div style="height: 2px; width: 80px; background-color: black; margin: 10px;"></div>
                    <p>Descubra mais sobre a próxima geração dos novos caças de combate da Sukhoi.</p>
                    <button>ver mais</button>
                </div>
                <div class="imagem" style="background-image: url('../imagens/su57.png');"></div>
            </div>
        </div>
    </section>
    
    <footer></footer>
</body>
</html>
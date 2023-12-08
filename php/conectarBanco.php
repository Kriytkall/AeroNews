<?php
$bd_host = "200.19.1.18";
$sgbd = "pgsql";
$base_de_dados = "luisbatista";
$bd_usuario = "luisbatista";
$bd_senha = "123456";

// Função para conectar ao banco de dados
function conectarBD() {
    global $bd_host, $sgbd, $base_de_dados, $bd_usuario, $bd_senha;
    try {
        $conn = new PDO("$sgbd:host=$bd_host;dbname=$base_de_dados", $bd_usuario, $bd_senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        return null;
    }
}

// Função para cadastrar uma notícia
function cadastrarNoticia($titulo, $subtitulo, $imgUrl, $noticia, $categorias) {
    $conn = conectarBD();
    if (!$conn) {
        return "Erro ao conectar ao banco de dados.";
    }

    try {
        $stmt = $conn->prepare("INSERT INTO tb_noticia (nm_titulo, nm_subtitulo, img_noticia, tx_noticia) VALUES (:titulo, :subtitulo, :imgUrl, :noticia)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':subtitulo', $subtitulo);
        $stmt->bindParam(':imgUrl', $imgUrl);
        $stmt->bindParam(':noticia', $noticia);
        $stmt->execute();

        $id_noticia = $conn->lastInsertId();

        // Associar notícia às categorias selecionadas
        foreach ($categorias as $id_categoria) {
            $stmt = $conn->prepare("INSERT INTO tb_noticia_categoria (id_noticia, id_categoria) VALUES (:id_noticia, :id_categoria)");
            $stmt->bindParam(':id_noticia', $id_noticia);
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->execute();
        }

        return "Notícia cadastrada com sucesso!";
    } catch (PDOException $e) {
        return "Erro ao cadastrar notícia: " . $e->getMessage();
    } catch (Exception $e) {
        return "Erro geral ao cadastrar notícia: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
    $subtitulo = isset($_POST["subtitulo"]) ? $_POST["subtitulo"] : '';
    $imgUrl = isset($_POST["imagem"]) ? $_POST["imagem"] : '';
    $noticia = isset($_POST["noticia"]) ? $_POST["noticia"] : '';

    // Ajuste para a nova estrutura dos checkboxes
    $categorias = isset($_POST["categorias"]) ? $_POST["categorias"] : [];

    if (empty($titulo) || empty($subtitulo) || empty($noticia) || empty($categorias)) {
        echo "Por favor, preencha todos os campos e selecione pelo menos uma categoria.";
    } else {
        $resultado = cadastrarNoticia($titulo, $subtitulo, $imgUrl, $noticia, $categorias);
        echo $resultado;
    }
}


function exibirTodasNoticias() {
    try {
        $conn = conectarBD();

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tb_noticia ORDER BY id_noticia DESC");
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        return "Erro ao buscar notícias: " . $e->getMessage();
    }
}


// Função para exibir notícias com base em uma categoria específica
function exibirNoticiasPorCategoria($categoria_id) {
    $conn = conectarBD();
    if (!$conn) {
        return null;
    }

    try {
        $stmt = $conn->prepare("
            SELECT tb_noticia.*
            FROM tb_noticia
            INNER JOIN tb_noticia_categoria ON tb_noticia.id_noticia = tb_noticia_categoria.id_noticia
            WHERE tb_noticia_categoria.id_categoria = :categoria_id ORDER BY id_noticia DESC
        ");

        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    } catch (PDOException $e) {
        return null;
    }
}


function lerNoticias($id_noticia) {
    try {
        $conn = conectarBD();
        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tb_noticia WHERE id_noticia = :id_noticia");
            $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        return "Erro ao buscar notícias: " . $e->getMessage();
    }
}

function deletarNoticia($id_noticia) {
    try {
        $conn = conectarBD();
        if ($conn) {
            // Excluir manualmente as referências na tabela tb_noticia_categoria
            $stmtDeleteCategoria = $conn->prepare("DELETE FROM tb_noticia_categoria WHERE id_noticia = :id_noticia");
            $stmtDeleteCategoria->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmtDeleteCategoria->execute();

            // Continuar com a exclusão da notícia após excluir as referências
            $stmt = $conn->prepare("DELETE FROM tb_noticia WHERE id_noticia = :id_noticia");
            $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmt->execute();

            // Verifica se a exclusão foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                return "Notícia deletada com sucesso!";
            } else {
                return "Nenhuma notícia encontrada para deletar com o ID fornecido.";
            }
        } else {
            return "Erro na conexão com o banco de dados.";
        }
    } catch (PDOException $e) {
        return "Erro ao deletar: " . $e->getMessage();
    }
}



function updateNoticia($id_noticia, $titulo, $subtitulo, $imgUrl, $noticia) {
    try {
        $conn = conectarBD();

        // Prepara a consulta de atualização
        $sql = "UPDATE tb_noticia SET
                nm_titulo = :titulo,
                nm_subtitulo = :subtitulo,
                img_noticia = :imgUrl,
                tx_noticia = :noticia
                WHERE id_noticia = :id_noticia";
        $stmt = $conn->prepare($sql);

        // Vincula os parâmetros da consulta
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':subtitulo', $subtitulo);
        $stmt->bindParam(':imgUrl', $imgUrl);
        $stmt->bindParam(':noticia', $noticia);
        $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);

        // Executa a consulta
        $stmt->execute();

        // Verifica se a consulta foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            return "Notícia atualizada com sucesso!";
        } else {
            return "Erro ao atualizar notícia.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}


?>
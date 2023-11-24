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
function cadastrarNoticia($titulo, $subtitulo, $imgUrl, $noticia) {
    $conn = conectarBD();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO tb_noticia (nm_titulo, nm_subtitulo, img_noticia, tx_noticia) VALUES (:titulo, :subtitulo, :imgUrl, :noticia)");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':subtitulo', $subtitulo);
            $stmt->bindParam(':imgUrl', $imgUrl);
            $stmt->bindParam(':noticia', $noticia);
            $stmt->execute();
            return "Notícia cadastrada com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao cadastrar notícia: " . $e->getMessage();
        }
    }
    return "Erro ao conectar ao banco de dados.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST["titulo"];
    $subtitulo = $_POST["subtitulo"];
    $imgUrl = $_POST["imagem"];
    $noticia = $_POST["noticia"];

    $resultado = cadastrarNoticia($titulo, $subtitulo, $imgUrl, $noticia);
    echo $resultado;
}

function exibirTodasNoticias() {
    try {
        $conn = conectarBD();

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM tb_noticia");
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
            $stmt = $conn->prepare("DELETE FROM tb_noticia WHERE id_noticia = :id_noticia");
            $stmt->bindParam(':id_noticia', $id_noticia, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    } catch (PDOException $e) {
        return "Erro ao deletar: " . $e->getMessage();
    }
}

function updateNoticia() {
    // Obtém os dados da notícia a ser atualizada
    $id_noticia = $_POST['id_noticia'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $imgUrl = $_POST['imagem'];
    $noticia = $_POST['noticia'];

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
}


?>
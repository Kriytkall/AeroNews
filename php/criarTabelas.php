<?php
$bd_host = "200.19.1.18";
$sgbd = "pgsql";
$base_de_dados = "luisbatista";
$bd_usuario = "luisbatista";
$bd_senha = "123456";

try {
    $dsn_pgsql = "pgsql:host=$bd_host;port=5432;dbname=$base_de_dados;";
    $conn = new PDO($dsn_pgsql, $bd_usuario, $bd_senha, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Query para criar a tabela de usuário
    $query_create_table = "
        CREATE TABLE tb_usuario(
            id_usuario SERIAL,
            nm_usuario VARCHAR NOT NULL,
            usr_email VARCHAR NOT NULL,
            usr_senha VARCHAR NOT NULL,
            isAdmin BOOLEAN NOT NULL DEFAULT false,
            PRIMARY KEY (id_usuario)
        )";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    // Query para criar a tabela de notícia
    $query_create_table = "
        CREATE TABLE tb_noticia(
            id_noticia SERIAL,
            nm_titulo VARCHAR NOT NULL,
            nm_subtitulo VARCHAR NOT NULL,
            img_noticia TEXT,
            tx_noticia TEXT NOT NULL,
            PRIMARY KEY (id_noticia)
        )";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    // Query para criar a tabela de categoria
    $query_create_table = "
        CREATE TABLE tb_categoria(
            id_categoria SERIAL NOT NULL,
            nm_categoria VARCHAR UNIQUE,
            PRIMARY KEY (id_categoria)
        )";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    // Query para criar a tabela de noticia_categoria
    $query_create_table = "
        CREATE TABLE tb_noticia_categoria(
            id_categoria INT NOT NULL,
            id_noticia INT NOT NULL,
            PRIMARY KEY (id_categoria, id_noticia),
            FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id_categoria),
            FOREIGN KEY (id_noticia) REFERENCES tb_noticia(id_noticia)
        )";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    echo 'Tabelas criadas com sucesso!';
} catch (PDOException $e) {
    echo 'Erro de Conexão: ' . $e->getMessage();
}
?>

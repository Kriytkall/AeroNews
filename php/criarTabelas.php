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
        create table tb_usuario(
            id_usuario serial,
            nm_usuario varchar not null,
            usr_email varchar not null,
            usr_senha varchar not null,
            isAdmin BOOLEAN NOT NULL DEFAULT false
        )
     ";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    // Query para adicionar chave primaria
    $query_pk_usuario = "
        alter table tb_usuario
        add constraint pk_usuario
        primary key(id_usuario)";
    $stmt_pk_usuario = $conn->prepare($query_pk_usuario);
    $stmt_pk_usuario->execute();

    // Query para criar a tabela de notícia
    $query_create_table = "
        create table tb_noticia(
            id_noticia serial,
            nm_titulo varchar not null,
            nm_subtitulo varchar not null,
            img_noticia text,
            tx_noticia text not null,
            id_usuario int not null
        )";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    // Query para adicionar chave primaria
    $query_pk_noticia = "
        alter table tb_noticia
        add constraint pk_noticia
        primary key(id_noticia)";
    $query_pk_noticia = $conn->prepare($query_pk_noticia);
    $query_pk_noticia->execute();

    // Query para adicionar a chave estrangeira
    $query_fk_noticia = "
        ALTER TABLE tb_noticia
        ADD CONSTRAINT fk_usuario
        FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)";
    $stmt_fk_noticia = $conn->prepare($query_fk_noticia);
    $stmt_fk_noticia->execute();


    echo 'Tabelas criadas e dados inseridos com sucesso!';

} catch (PDOException $e) {
    echo 'Erro de Conexão: ' . $e->getMessage();
}
?>

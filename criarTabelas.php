<?php
$bd_host = "200.19.1.18";
$sgbd = "pgsql";
$base_de_dados = "luisbatista";
$bd_usuario = "luisbatista";
$bd_senha = "123456";

try {
    $dsn_pgsql = "pgsql:host=$bd_host;port=5432;dbname=$base_de_dados;";
    $conn = new PDO($dsn_pgsql, $bd_usuario, $bd_senha, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo 'Conectado!';

    // Query para criar a tabela
    $query_create_table = "
        create table tb_noticia(
            id_noticia serial,
            nm_titulo varchar not null,
            nm_subtitulo varchar not null,
            img_noticia text,
            tx_noticia text not null
        )";
    $stmt_create_table = $conn->prepare($query_create_table);
    $stmt_create_table->execute();

    // Query para adicionar chave estrangeira
    $query_pk_noticia = "
        alter table tb_noticia
        add constraint pk_noticia
        primary key(id_noticia)";
    $query_pk_noticia = $conn->prepare($query_pk_noticia);
    $query_pk_noticia->execute();

    echo 'Tabela criada e dados inseridos com sucesso!';

} catch (PDOException $e) {
    echo 'Erro de Conexão: ' . $e->getMessage();
}
?>

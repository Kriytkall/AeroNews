<?php

$bd_host = "200.19.1.18";
$sgbd = "pgsql";
$base_de_dados = "luisbatista";
$bd_usuario = "luisbatista";
$bd_senha = "123456";

function conectarBD() {
    global $bd_host, $sgbd, $base_de_dados, $bd_usuario, $bd_senha;
    try {
        $conn = new PDO("$sgbd:host=$bd_host;dbname=$base_de_dados", $bd_usuario, $bd_senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados. Por favor, tente novamente.";
        return null;
    }
}

function cadastrarUsuario($nm_usuario, $usuario, $senha) {
    if (empty($nm_usuario) || empty($usuario) || empty($senha)) {
        return false;
    }

    $conn = conectarBD();
    if (!$conn) {
        die("Falha na conexão com o banco de dados");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $query = "INSERT INTO tb_usuario (nm_usuario, usr_email, usr_senha) VALUES (:nm_usuario, :usuario, :senha)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nm_usuario', $nm_usuario);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':senha', $senha_hash);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Erro ao cadastrar o usuário: " . $e->getMessage();
        return false;
    } finally {
        $conn = null;
    }
}

function verificarLogin($usuario, $senha) {
    $conn = conectarBD();
    if (!$conn) {
        die("Falha na conexão com o banco de dados");
    }

    $query = "SELECT * FROM tb_usuario WHERE usr_email = :usuario";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    $usuario_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario_info && password_verify($senha, $usuario_info['usr_senha'])) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST["acao"];

    if ($acao == "cadastro") {

    } elseif ($acao == "login") {
        $usuario = $_POST["usr_email"];
        $senha = $_POST["usr_senha"];

        if (verificarLogin($usuario, $senha)) {
            $conn = conectarBD();
            $query = "SELECT id_usuario FROM tb_usuario WHERE usr_email = :usuario";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $usuario_info = $stmt->fetch(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["idUsuario"] = $usuario_info['id_usuario'];

            header("Location: ../php/home.php");
            exit();
        } else {
            echo "Usuário ou senha incorretos.";
        }
    } else {
        echo "Ação inválida.";
    }
}
?>

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
        echo "Erro ao conectar ao banco de dados. Por favor, tente novamente.";
        // Em um ambiente de produção, remova ou registre a mensagem de erro em logs, mas não a exiba para os usuários.
        // error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
        return null;
    }
}

function cadastrarUsuario($nm_usuario, $usuario, $senha) {
    // Verificar se todos os campos estão preenchidos corretamente
    if (empty($nm_usuario) || empty($usuario) || empty($senha)) {
        return false; // Erro ao cadastrar o usuário
    }

    // Chamar a função conectarBD
    $conn = conectarBD();

    // Verificar se a conexão foi estabelecida com sucesso
    if (!$conn) {
        die("Falha na conexão com o banco de dados");
    }

    // Utilizar consultas preparadas para evitar SQL injection
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $query = "INSERT INTO tb_usuario (nm_usuario, usr_email, usr_senha) VALUES (:nm_usuario, :usuario, :senha)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nm_usuario', $nm_usuario);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':senha', $senha_hash);

    try {
        $stmt->execute();
        return true; // Usuário cadastrado com sucesso
    } catch (PDOException $e) {
        echo "Erro ao cadastrar o usuário: " . $e->getMessage();
        return false; // Erro ao cadastrar o usuário
    } finally {
        // Fechar a conexão com o banco de dados
        $conn = null;
    }
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os valores do formulário
    $acao = $_POST["acao"];

    if ($acao == "cadastro") {
        // Ação de cadastro
        $nm_usuario = $_POST["nm_usuario"];
        $usuario = $_POST["usr_email"];
        $senha = $_POST["usr_senha"];

        $resultado = cadastrarUsuario($nm_usuario, $usuario, $senha);
        if ($resultado) {
            echo "Usuário cadastrado com sucesso. Faça o login.";
        } else {
            echo "Erro ao cadastrar o usuário. Tente novamente.";
        }
    } elseif ($acao == "login") {
        // Ação de login
        $usuario = $_POST["usr_email"];
        $senha = $_POST["usr_senha"];

        function verificarLogin($usuario, $senha) {
            // Chamar a função conectarBD
            $conn = conectarBD();

            // Verificar se a conexão foi estabelecida com sucesso
            if (!$conn) {
                die("Falha na conexão com o banco de dados");
            }

            // Utilizar consultas preparadas para evitar SQL injection
            $query = "SELECT * FROM tb_usuario WHERE usr_email = :usuario";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();

            // Verificar se o usuário existe
            $usuario_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario_info && password_verify($senha, $usuario_info['usr_senha'])) {
                // Usuário autenticado com sucesso
                return true;
            } else {
                // Usuário ou senha incorretos
                return false;
            }
        }

        // Verificar o login
        if (verificarLogin($usuario, $senha)) {
            // Inicie a sessão e armazene o ID do usuário
            session_start();
            $_SESSION["idUsuario"] = $usuario_info['id_usuario'];

            // Redirecionar para a página principal, se necessário
            header("Location: ../php/home.php");
            exit(); // Certifique-se de encerrar o script após redirecionar
        } else {
            echo "Usuário ou senha incorretos.";
        }
    } else {
        echo "Ação inválida.";
    }
}

?>

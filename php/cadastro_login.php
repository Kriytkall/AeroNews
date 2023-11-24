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

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os valores do formulário
    $usuario = $_POST["usr_email"];
    $senha = $_POST["usr_senha"];

    // Função para verificar o login
    function verificarLogin($usuario, $senha) {
        // Chamar a função conectarBD
        $conn = conectarBD();

        // Verificar se a conexão foi estabelecida com sucesso
        if (!$conn) {
            die("Falha na conexão com o banco de dados");
        }

        // Sanitizar inputs para evitar SQL injection
        $usuario = $conn->quote($usuario);
        $senha = $conn->quote($senha);

        // Consulta SQL para verificar as credenciais
        $query = "SELECT * FROM tb_usuario WHERE usr_email = $usuario AND usr_senha = $senha";
        
        try {
            $result = $conn->query($query);

            // Verificar se o usuário e a senha correspondem
            if ($result->rowCount() == 1) {
                // Usuário autenticado com sucesso
                return true;
            } else {
                // Usuário ou senha incorretos
                return false;
            }
        } catch (PDOException $e) {
            die("Erro na consulta ao banco de dados: " . $e->getMessage());
        } finally {
            // Fechar a conexão com o banco de dados
            $conn = null;
        }
    }

    // Verificar o login
    if (verificarLogin($usuario, $senha)) {
        // Redirecionar para a página principal, se necessário
        header("Location: ../pages/home.html");
    } else {
        echo "Usuário ou senha incorretos.";
    }
}
?>

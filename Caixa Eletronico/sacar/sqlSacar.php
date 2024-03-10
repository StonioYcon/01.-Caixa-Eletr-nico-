<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: ../login/index.html");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "caixaeletronico";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$senha = $_POST["senha"];
$valor = $_POST["valor"];

$numero_cartao = $_POST["numeroCartao"]; 

$sql_verificar_senha = "SELECT * FROM contas WHERE numero_cartao = '$numero_cartao' AND senha = '$senha'";
$result_verificar_senha = $conn->query($sql_verificar_senha);

if ($result_verificar_senha->num_rows == 0) {
    echo "Senha incorreta";
    exit;
}

if ($valor <= 0) {
    echo "O valor do saque deve ser positivo";
    exit;
}

$sql_saldo = "SELECT saldo FROM contas WHERE numero_cartao = '$numero_cartao'";
$result_saldo = $conn->query($sql_saldo);

if ($result_saldo->num_rows > 0) {
    $row_saldo = $result_saldo->fetch_assoc();
    $saldo_atual = $row_saldo["saldo"];

    if ($saldo_atual >= $valor) {
    
        $novo_saldo = $saldo_atual - $valor;

        $sql_atualizar_saldo = "UPDATE contas SET saldo = $novo_saldo WHERE numero_cartao = '$numero_cartao'";
        if ($conn->query($sql_atualizar_saldo) === TRUE) {
            echo "Saque realizado com sucesso!";
        } else {
            echo "Erro ao atualizar o saldo: " . $conn->error;
        }
    } else {
        echo "Saldo insuficiente para realizar o saque";
    }
} else {
    echo "Erro ao recuperar o saldo";
}

$conn->close();
?>

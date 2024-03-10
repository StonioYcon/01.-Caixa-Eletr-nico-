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

$numero_cartao_destinatario = $_POST["numeroRecebe"];
$numero_cartao_remetente = $_POST["numeroenviar"];
$senha = $_POST["senha"];
$valor = $_POST["valor"];


if ($senha != $senha) {
    echo "Senha incorreta";
    exit;
}

$sql_destinatario = "SELECT * FROM contas WHERE numero_cartao = '$numero_cartao_destinatario'";
$result_destinatario = $conn->query($sql_destinatario);

if ($result_destinatario->num_rows == 0) {
    echo "Destinatário não encontrado";
    exit;
}

$sql_saldo_remetente = "SELECT saldo FROM contas WHERE numero_cartao = '$numero_cartao_remetente'";
$result_saldo_remetente = $conn->query($sql_saldo_remetente);

if ($result_saldo_remetente->num_rows > 0) {
    $row_saldo_remetente = $result_saldo_remetente->fetch_assoc();
    $saldo_remetente_atual = $row_saldo_remetente["saldo"];


    if ($saldo_remetente_atual >= $valor) {
        
        $novo_saldo_remetente = $saldo_remetente_atual - $valor;

        
        $sql_atualizar_saldo_remetente = "UPDATE contas SET saldo = $novo_saldo_remetente WHERE numero_cartao = '$numero_cartao_remetente'";
        $conn->query($sql_atualizar_saldo_remetente);

        $sql_saldo = "UPDATE contas SET saldo = saldo + $valor WHERE numero_cartao = '$numero_cartao_destinatario'";
        $conn->query($sql_saldo);

        

        echo "Transferência realizada com sucesso";
    } else {
        echo "Saldo insuficiente para realizar a transferência";
    }
} else {
    echo "Erro ao recuperar o saldo do remetente";
}

$conn->close();
?>

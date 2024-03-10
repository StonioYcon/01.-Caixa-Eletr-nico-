<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$databse = "caixaeletronico";

$conn = new mysqli($servername,$username,$password,$databse);
if ($conn->connect_error) {
    die("A conexão falhou".$conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $numeroCartao = $_POST["numerocartao"];
    $senhaCartao = $_POST["senhacartao"];

    $sql = "SELECT * FROM contas WHERE numero_cartao = '$numeroCartao' AND senha = '$senhaCartao'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['logged_in'] = true;
        header("Location: ../menu\menu.html");
    } else {
        echo "O número do cartão ou a senha está incorreta!";
    }
}

?>

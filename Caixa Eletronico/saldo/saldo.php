<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        header {
            background-color: #003366;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }

        article {
            margin: 20px auto;
            width: 80%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        footer {
            background-color: #003366;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        p {
            font-size: 18px;
        }

        footer p {
            font-size: 16px;
            margin: 0;
        }

        footer p span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Saldo</h1>
    </header>

    <article>
        <p>Meu saldo e de:</p>
    </article>
    <footer>
    <?php
        // Conectar ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "caixaeletronico";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "SELECT nome, saldo FROM contas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo  $row["saldo"]. "<br>";
            }
        } else {
            echo "Nenhum resultado encontrado";
        }
        $conn->close();
        ?>
    </footer>
</body>
</html>

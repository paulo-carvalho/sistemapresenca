<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "sistema_presenca";

    // Criar conexao
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checar conexao
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
?>

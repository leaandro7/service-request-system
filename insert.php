<?php

require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $categoria = $_POST['categoria'];
    $turno = $_POST['turno'];
    $descricao = $_POST['descricao'];

    if (!empty($categoria) && !empty($turno)) {
        // descricao não pode ser usado sem aspas, pois é comando sql
        $stmt = $pdo->prepare("INSERT INTO chamados (categoria, turno, descricao) VALUES (:categoria, :turno, :descricao)");
        $stmt->execute([
            ":categoria" => $categoria,
            ":turno" => $turno,
            ":descricao" => $descricao
        ]);

        header("Location: index.php?page=dashboard");
        exit;
    } else {
        echo ("POST falhou");
    }
}

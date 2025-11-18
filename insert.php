<?php

require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $categoria = $_POST['categoria'];
    $turno = $_POST['turno'];
    $descricao = $_POST['descricao'];

    // VALIDAÇÃO: Descrição deve ter no máximo 50 caracteres
    if (strlen($descricao) > 50) {
        die("Erro: A descrição deve ter no máximo 50 caracteres.");
    }

    if (!empty($categoria) && !empty($turno)) {

        $stmt = $pdo->prepare("
            INSERT INTO chamados (categoria, turno, descricao) 
            VALUES (:categoria, :turno, :descricao)
        ");

        $stmt->execute([
            ":categoria" => $categoria,
            ":turno" => $turno,
            ":descricao" => $descricao
        ]);

        header("Location: index.php?page=dashboard");
        exit;

    } else {
        echo "POST falhou";
    }
}

<?php

require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];

    if (!$id) {
        echo "ID não informado.";
        exit;
    }

    // Excluir registro
    $stmt = $pdo->prepare("
        DELETE FROM chamados
        WHERE id = :id
    ");

    $stmt->execute([":id" => $id]);

    echo "Registro deletado com sucesso!";
}

?>

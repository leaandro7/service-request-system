<?php

require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $action = $_POST['action'];

    if (!$id || !$action) {
        echo "Faltando parâmetros.";
        exit;
    }

    switch ($action) {
        case "iniciar":
            $stmt = $pdo->prepare("
                UPDATE chamados
                SET
                    status = 1,
                    tempo_inicio = NOW()
                WHERE id = :id
            ");
            $stmt->execute([":id" => $id]);
            echo "att iniciar FEITA!";
        break;

        case "finalizar":
            $stmt = $pdo->prepare("
                UPDATE chamados
                SET
                    status = 2,
                    tempo_fim = NOW(),
                    duracao = TIMESTAMPDIFF(SECOND, tempo_inicio, NOW())
                WHERE id = :id
            ");
            $stmt->execute([":id" => $id]);
            echo "att finalizar FEITA!";
        break;

        case "suspender":
            $stmt = $pdo->prepare("
                UPDATE chamados
                SET
                    status = 3
                WHERE id = :id
            ");
            $stmt->execute([":id" => $id]);
            echo "att suspender FEITA!";
        break;
    }

}

?>

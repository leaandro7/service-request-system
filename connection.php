<?php 
$host = 'localhost';
$dbname = 'chamados_db';
$user = 'root';
$pass = '';

try {
    // Conexão
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Definindo atributos (modo de erro, tipo de fetch, etc)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Erro ao conectar com o Banco de Dados: " . $e->getMessage();
}
?>
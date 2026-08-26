<?php

include "../infra/conexao.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$id_cliente = $_GET['id'];


$conexao->begin_transaction();

try {
  
    $sql_animais = "DELETE FROM animais WHERE id_cliente = ?";
    $stmt_animais = $conexao->prepare($sql_animais);
    $stmt_animais->bind_param("i", $id_cliente);
    
    if (!$stmt_animais->execute()) {
        throw new Exception("Erro ao excluir animais: " . $stmt_animais->error);
    }
    
    $stmt_animais->close();
    
   
    $sql_cliente = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt_cliente = $conexao->prepare($sql_cliente);
    $stmt_cliente->bind_param("i", $id_cliente);
    
    if (!$stmt_cliente->execute()) {
        throw new Exception("Erro ao excluir cliente: " . $stmt_cliente->error);
    }
    
    $stmt_cliente->close();
    
    $conexao->commit();
    
    header("Location: ../index.php");
    exit();
    
} catch (Exception $e) {
    $conexao->rollback();
    
    echo "Erro ao excluir cliente: " . $e->getMessage();
    echo "<br><a href='../index.php'>Voltar</a>";
}

$conexao->close();

?>
<?php

include("../infra/conexao.php");

$id = $_GET["id"];

$sql = "DELETE FROM animais WHERE id = $id";

if ($conn->query($sql)) {

    header("Location: cadastrar_animal.php");

} else {

    echo "Erro ao excluir animal.";

}

?>
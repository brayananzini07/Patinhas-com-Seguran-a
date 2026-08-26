<?php

include("../infra/conexao.php");

$id = $_POST["id"];
$nome = $_POST["nome"];
$especie = $_POST["especie"];
$raca = $_POST["raca"];
$idade = $_POST["idade"];
$cliente_id = $_POST["cliente_id"];

$sql = "UPDATE animais SET
        nome = '$nome',
        especie = '$especie',
        raca = '$raca',
        idade = '$idade',
        cliente_id = '$cliente_id'
        WHERE id = $id";

if ($conn->query($sql)) {

    header("Location: cadastrar_animal.php");

} else {

    echo "Erro ao atualizar animal.";

}

?>
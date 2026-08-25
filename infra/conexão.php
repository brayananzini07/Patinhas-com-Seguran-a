<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "patinhas_com_segurança";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
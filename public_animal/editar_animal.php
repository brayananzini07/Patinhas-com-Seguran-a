<?php

include("../infra/conexao.php");

$id = $_GET["id"];

$sql = "SELECT * FROM animais WHERE id = $id";

$resultado = $conn->query($sql);

$animal = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Animal</title>
</head>

<body>

    <h1>Editar Animal</h1>

    <form action="atualizar_animal.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo $animal["id"]; ?>"
        >

        Nome:

        <input
            type="text"
            name="nome"
            value="<?php echo $animal["nome"]; ?>"
        >

        <br><br>

        Espécie:

        <input
            type="text"
            name="especie"
            value="<?php echo $animal["especie"]; ?>"
        >

        <br><br>

        Raça:

        <input
            type="text"
            name="raca"
            value="<?php echo $animal["raca"]; ?>"
        >

        <br><br>

        Idade:

        <input
            type="number"
            name="idade"
            value="<?php echo $animal["idade"]; ?>"
        >

        <br><br>

        Responsável:

        <select name="cliente_id">

            <?php

            $sql = "SELECT * FROM clientes";

            $resultado = $conn->query($sql);

            while ($cliente = $resultado->fetch_assoc()) {

                echo "<option value='" .
                    $cliente["id"] .
                    "'>";

                echo $cliente["nome"];

                echo "</option>";
            }

            ?>

        </select>

        <br><br>

        <button type="submit">
            Atualizar
        </button>

    </form>

</body>

</html>
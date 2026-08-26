<?php

include "../infra/conexao.php";

$erro = "";
$clientes = [];

$resultado = mysqli_query($conexao, "SELECT id_cliente, nome FROM clientes ORDER BY nome");

while ($cliente = mysqli_fetch_assoc($resultado)) {
    $clientes[] = $cliente;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $especie = trim($_POST["especie"]);
    $raca = trim($_POST["raca"]);
    $idade = (int) $_POST["idade"];
    $id_cliente = (int) $_POST["id_cliente"];

    if (empty($nome) || empty($especie) || empty($raca) || $idade < 0 || $id_cliente <= 0) {
        $erro = "Preencha todos os campos!";
    } else {

        $sql = "SELECT id_cliente FROM clientes WHERE id_cliente = ?";
        $verificar = $conexao->prepare($sql);
        $verificar->bind_param("i", $id_cliente);
        $verificar->execute();

        if ($verificar->get_result()->num_rows == 0) {
            $erro = "Cliente não encontrado!";
        } else {

            $sql = "INSERT INTO animais (nome, especie, raca, idade, id_cliente) VALUES (?, ?, ?, ?, ?)";
            $cadastro = $conexao->prepare($sql);
            $cadastro->bind_param("sssii", $nome, $especie, $raca, $idade, $id_cliente);

            if ($cadastro->execute()) {
                echo '<script>window.top.location.href = "../index.php";</script>';
                exit();
            }

            $erro = "Erro ao cadastrar: " . $cadastro->error;
            $cadastro->close();
        }

        $verificar->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Cadastrar Pet</title>
</head>

<body class="pagina_formulario">

    <div class="formulario_cabecalho">
        <h1>Cadastrar Pet</h1>
    </div>

    <main class="formulario">
        <p>Preencha os dados do novo pet.</p>

        <form action="cadastrar_animais.php" method="POST">

            <label for="nome">Nome do Pet:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="especie">Espécie:</label>
            <input type="text" name="especie" id="especie" required>

            <label for="raca">Raça:</label>
            <input type="text" name="raca" id="raca" required>

            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" min="0" required>

            <label for="id_cliente">Tutor:</label>
            <select name="id_cliente" id="id_cliente" required>
                <option value="">Selecione o tutor</option>

                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>">
                        <?php echo htmlspecialchars($cliente['nome']); ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <div class="botoes_forms">
                <a class="botao" href="../index.php" target="_top">Voltar</a>
                <button class="botao botao_principal" type="submit">Cadastrar</button>
            </div>

        </form>

        <?php if ($erro): ?>
            <div class="mensagem_erro">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>
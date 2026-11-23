<?php

include 'includes/conectar.inc.php';
include 'includes/criarBase.inc.php';
include 'includes/criarTabelas.inc.php';

$mensagem = '';
$acao = '';
$nomePesquisa = '';
$totalPacientes = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'];

    if ($acao == 'cadastrarMedico') {
        $crm = $_POST['crm'];
        $nome = $_POST['nome'];

        $sql = 'INSERT INTO medicos (crm, nome) VALUES (?, ?)';
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ss', $crm, $nome);

        if (!$comando->execute()) {
            die('Erro ao cadastrar o médico.');
        }

        $mensagem = 'Médico cadastrado com sucesso.';
        $comando->close();
    } elseif ($acao == 'cadastrarPaciente') {
        $idPaciente = $_POST['idPaciente'];
        $nomePaciente = $_POST['nomePaciente'];
        $crm = $_POST['crm'];
        $dataInternacao = $_POST['dataInternacao'];

        $sql = 'INSERT INTO pacientes (id, nome, crm_medico, data_internacao) VALUES (?, ?, ?, ?)';
        $comando = $conexao->prepare($sql);
        $comando->bind_param('isss', $idPaciente, $nomePaciente, $crm, $dataInternacao);

        if (!$comando->execute()) {
            die('Erro ao cadastrar o paciente.');
        }

        $mensagem = 'Paciente cadastrado com sucesso.';
        $comando->close();
    } elseif ($acao == 'pesquisarMedico') {
        $nomePesquisa = $_POST['nomePesquisa'];

        $sql = 'SELECT COUNT(pacientes.id) AS total
                FROM medicos
                LEFT JOIN pacientes ON medicos.crm = pacientes.crm_medico
                WHERE medicos.nome = ?';
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $nomePesquisa);

        if (!$comando->execute()) {
            die('Erro ao pesquisar o médico.');
        }

        $dados = $comando->get_result()->fetch_assoc();
        $totalPacientes = $dados['total'];
        $comando->close();
    }
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultado da operação</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <main class="cartao">
        <h1>Resultado</h1>

        <?php if ($mensagem != ''): ?>
            <p class="mensagem sucesso"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <?php if ($acao == 'pesquisarMedico'): ?>
            <p>
                Número de pacientes atendidos pelo médico
                <strong><?php echo htmlspecialchars($nomePesquisa); ?></strong>:
                <strong><?php echo $totalPacientes; ?></strong>
            </p>
        <?php endif; ?>

        <a href="index.php">Voltar</a>
    </main>
</body>

</html>
<?php
$conexao->close();

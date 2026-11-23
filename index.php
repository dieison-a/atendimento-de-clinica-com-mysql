<?php

include 'includes/conectar.inc.php';
include 'includes/criarBase.inc.php';
include 'includes/criarTabelas.inc.php';

$sql = 'SELECT crm, nome FROM medicos ORDER BY nome';
$resultadoMedicos = $conexao->query($sql);

if (!$resultadoMedicos) {
    die('Erro ao listar os médicos: ' . $conexao->error);
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atendimento da clínica</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <main class="cartao">
        <h1>Controle de atendimento</h1>

        <section>
            <h2>Cadastrar médico</h2>
            <form action="main.php" method="post">
                <input type="hidden" name="acao" value="cadastrarMedico" />

                <label for="crmMedico">CRM:</label>
                <input type="text" name="crm" id="crmMedico" maxlength="20" required />

                <label for="nomeMedico">Nome do médico:</label>
                <input type="text" name="nome" id="nomeMedico" maxlength="100" required />

                <button type="submit">Cadastrar médico</button>
            </form>
        </section>

        <section>
            <h2>Cadastrar paciente</h2>
            <form action="main.php" method="post">
                <input type="hidden" name="acao" value="cadastrarPaciente" />

                <label for="idPaciente">Identificador do paciente:</label>
                <input type="number" name="idPaciente" id="idPaciente" min="1" step="1" required />

                <label for="nomePaciente">Nome do paciente:</label>
                <input type="text" name="nomePaciente" id="nomePaciente" maxlength="100" required />

                <label for="crmAtendimento">Médico que atendeu:</label>
                <select name="crm" id="crmAtendimento" required>
                    <option value="">Selecione um médico</option>
                    <?php while ($medico = $resultadoMedicos->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($medico['crm']); ?>">
                            <?php echo htmlspecialchars($medico['nome'] . ' (CRM ' . $medico['crm'] . ')'); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="dataInternacao">Data da internação:</label>
                <input type="date" name="dataInternacao" id="dataInternacao" required />

                <button type="submit">Cadastrar paciente</button>
            </form>
        </section>

        <section>
            <h2>Pesquisar atendimentos por médico</h2>
            <form action="main.php" method="post">
                <input type="hidden" name="acao" value="pesquisarMedico" />

                <label for="nomePesquisa">Nome do médico:</label>
                <input type="text" name="nomePesquisa" id="nomePesquisa" maxlength="100" required />

                <button type="submit">Pesquisar</button>
            </form>
        </section>
    </main>
</body>

</html>
<?php

$conexao->close();

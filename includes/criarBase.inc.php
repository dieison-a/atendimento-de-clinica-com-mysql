<?php

$sql = 'CREATE DATABASE IF NOT EXISTS clinica_medica';

if (!$conexao->query($sql)) {
    die('Erro ao criar o banco de dados: ' . $conexao->error);
}

if (!$conexao->select_db('clinica_medica')) {
    die('Erro ao selecionar o banco de dados: ' . $conexao->error);
}

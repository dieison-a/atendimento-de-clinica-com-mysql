<?php

$sql = 'CREATE TABLE IF NOT EXISTS medicos (
    crm VARCHAR(20) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
) ENGINE=InnoDB';

if (!$conexao->query($sql)) {
    die('Erro ao criar a tabela de médicos: ' . $conexao->error);
}

$sql = 'CREATE TABLE IF NOT EXISTS pacientes (
    id INT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    crm_medico VARCHAR(20) NOT NULL,
    data_internacao DATE NOT NULL,
    FOREIGN KEY (crm_medico) REFERENCES medicos(crm)
) ENGINE=InnoDB';

if (!$conexao->query($sql)) {
    die('Erro ao criar a tabela de pacientes: ' . $conexao->error);
}

$sql = "INSERT IGNORE INTO medicos (crm, nome) VALUES
    ('CRM1001', 'Dra. Camila Rocha'),
    ('CRM1002', 'Dr. Felipe Martins'),
    ('CRM1003', 'Dra. Julia Costa'),
    ('CRM1004', 'Dr. Renato Alves'),
    ('CRM1005', 'Dra. Beatriz Lima')";

if (!$conexao->query($sql)) {
    die('Erro ao cadastrar os médicos iniciais: ' . $conexao->error);
}

$sql = "INSERT IGNORE INTO pacientes (id, nome, crm_medico, data_internacao) VALUES
    (1001, 'Lucas Pereira', 'CRM1001', '2025-03-12'),
    (1002, 'Mariana Souza', 'CRM1002', '2025-04-08'),
    (1003, 'Gabriel Oliveira', 'CRM1003', '2025-05-21'),
    (1004, 'Isabela Ferreira', 'CRM1004', '2025-06-02'),
    (1005, 'Rafael Santos', 'CRM1005', '2025-07-14')";

if (!$conexao->query($sql)) {
    die('Erro ao cadastrar os pacientes iniciais: ' . $conexao->error);
}

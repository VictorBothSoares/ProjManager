<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configurações do banco de dados
    $host = 'localhost';
    $dbname = 'mydb';
    $username = 'root';
    $password = '';

    try {
        // Conexão com o banco de dados
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a instrução SQL de inserção
        $sql = "INSERT INTO Cliente (Nome, sobrenome, `CPF/CNPJ`, email, Telefone, Endereco, CEP, bairro, cidade, numero, UF, Complemento)
        VALUES (:nome, :sobrenome, :cpf_cnpj, :email, :telefone, :endereco, :cep, :bairro, :cidade, :numero, :uf, :complemento)";

        $stmt = $conn->prepare($sql);

        // Parâmetros da inserção
        $params = array(
            ':nome' => $_POST['nome'],
            ':sobrenome' => $_POST['sobrenome'],
            ':cpf_cnpj' => $_POST['cpf_cnpj'],
            ':email' => $_POST['email'],
            ':telefone' => $_POST['telefone'],
            ':endereco' => $_POST['endereco'],
            ':cep' => $_POST['cep'],
            ':bairro' => $_POST['bairro'],
            ':cidade' => $_POST['cidade'],
            ':numero' => $_POST['numero'],
            ':uf' => $_POST['uf'],
            ':complemento' => $_POST['complemento']
        );

        // Executa a inserção
        $stmt->execute($params);

        echo 'Dados inseridos com sucesso!';
    } catch (PDOException $e) {
        echo 'Erro ao inserir os dados: ' . $e->getMessage();
    }
}
?>
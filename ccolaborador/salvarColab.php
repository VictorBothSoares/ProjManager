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

        // Verifica se o CPF/CNPJ já existe no banco de dados
        $cpfCnpj = $_POST['cpf_cnpj'];
        $sqlSelect = "SELECT COUNT(*) as count FROM funcionario WHERE `CPF_CNPJ` = :cpf_cnpj";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':cpf_cnpj', $cpfCnpj);
        $stmtSelect->execute();

        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        if ($count > 0) {
            // CPF/CNPJ já existe, realiza um UPDATE
            $sql = "UPDATE funcionario SET Nome = :nome, sobrenome = :sobrenome, Email = :email, Telefone = :telefone, Endereco = :endereco, CEP = :cep, bairro = :bairro, cidade = :cidade, numero = :numero, UF = :uf, Complemento = :complemento WHERE `CPF_CNPJ` = :cpf_cnpj";
        } else {
            // CPF/CNPJ não existe, realiza um INSERT
            $sql = "INSERT INTO funcionario (Nome, sobrenome, Email, CPF_CNPJ, Telefone, Endereco, CEP, bairro, cidade, numero, UF, Complemento)
            VALUES (:nome, :sobrenome, :email, :cpf_cnpj, :telefone, :endereco, :cep, :bairro, :cidade, :numero, :uf, :complemento)";
        }

        $stmt = $conn->prepare($sql);

        // Parâmetros da inserção ou atualização
        $params = array(
            ':nome' => $_POST['nome'],
            ':sobrenome' => $_POST['sobrenome'],
            ':email' => $_POST['email'],
            ':cpf_cnpj' => $_POST['cpf_cnpj'],
            ':telefone' => $_POST['telefone'],
            ':endereco' => $_POST['endereco'],
            ':cep' => $_POST['cep'],
            ':bairro' => $_POST['bairro'],
            ':cidade' => $_POST['cidade'],
            ':numero' => $_POST['numero'],
            ':uf' => $_POST['uf'],
            ':complemento' => $_POST['complemento']
        );

        // Executa a inserção ou atualização
        $stmt->execute($params);

        echo 'Dados inseridos/atualizados com sucesso!';
    } catch (PDOException $e) {
        echo 'Erro ao inserir/atualizar os dados: ' . $e->getMessage();
    }
}
?>
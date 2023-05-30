<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configurações do banco de dados
    include('../Banco de dados/conexao.php');

    try {
        // Conexão com o banco de dados
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifica se o CPF/CNPJ já existe no banco de dados
        $cpfCnpj = $_POST['cpf_cnpj'];
        $sqlSelect = "SELECT COUNT(*) as count FROM Cliente WHERE `CPF/CNPJ` = :cpf_cnpj";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':cpf_cnpj', $cpfCnpj);
        $stmtSelect->execute();

        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        if ($count > 0) {
            // CPF/CNPJ já existe, realiza um UPDATE
            $sql = "UPDATE Cliente SET Nome = :nome, sobrenome = :sobrenome, email = :email, Telefone = :telefone, Endereco = :endereco, CEP = :cep, bairro = :bairro, cidade = :cidade, numero = :numero, UF = :uf, Complemento = :complemento WHERE `CPF/CNPJ` = :cpf_cnpj";
        } else {
            // CPF/CNPJ não existe, realiza um INSERT
            $sql = "INSERT INTO Cliente (Nome, sobrenome, `CPF/CNPJ`, email, Telefone, Endereco, CEP, bairro, cidade, numero, UF, Complemento)
            VALUES (:nome, :sobrenome, :cpf_cnpj, :email, :telefone, :endereco, :cep, :bairro, :cidade, :numero, :uf, :complemento)";
        }

        $stmt = $conn->prepare($sql);

        // Parâmetros da inserção ou atualização
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
            ':complemento' => $_POST['Complemento']
        );

        // Executa a inserção ou atualização
        $stmt->execute($params);

        echo 'Dados inseridos/atualizados com sucesso!';
    } catch (PDOException $e) {
        echo 'Erro ao inserir/atualizar os dados: ' . $e->getMessage();
    }
}
?>
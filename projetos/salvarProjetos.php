<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configurações do banco de dados
    include('../Banco de dados/conexao.php');

    try {
        // Conexão com o banco de dados
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifica se o NomeProjeto já existe no banco de dados
        $nomeProjeto = $_POST['nome_projeto'];
        $sqlSelect = "SELECT COUNT(*) as count FROM projetos WHERE NomeProjeto = :nome_projeto";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':nome_projeto', $nomeProjeto);
        $stmtSelect->execute();

        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        if ($count > 0) {
            $sql = "UPDATE projetos SET verba = :verba, valorGasto = :valor_gasto, Cliente_idCliente = :cliente_id, Descricao = :descricao, dataInicio = :data_inicio, DataConclusao = :data_conclusao WHERE NomeProjeto = :nome_projeto";
        } else {
            $sql = "INSERT INTO projetos (NomeProjeto, verba, valorGasto, Descricao, Cliente_idCliente, dataInicio, DataConclusao)
            VALUES (:nome_projeto, :verba, :valor_gasto, :descricao, :cliente_id, :data_inicio, :data_conclusao)";
        }

        $stmt = $conn->prepare($sql);

        // Parâmetros da inserção ou atualização
        $params = array(
            ':nome_projeto' => $_POST['nome_projeto'],
            ':verba' => $_POST['verba'],
            ':valor_gasto' => $_POST['valor_gasto'],
            ':descricao' => $_POST['descricao'],
            ':cliente_id' => $_POST['cliente_id'],
            ':data_inicio' => $_POST['data_criacao'],
            ':data_conclusao' => $_POST['data_conclusao']
        );

        // Executa a inserção ou atualização
        $stmt->execute($params);

        echo 'Dados inseridos/atualizados com sucesso!';
    } catch (PDOException $e) {
        echo 'Erro ao inserir/atualizar os dados: ' . $e->getMessage();
    }
}
?>

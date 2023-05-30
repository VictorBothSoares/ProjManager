<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos - ProjManager</title>
    <link rel="stylesheet" href="projetosstyle.css">
</head>
<body>
    <header>
        <nav class="navegacao">
        </nav>
        <a href="../login.html">
            <p class="sair">Sair</p>
        </a>
        <a href="../index.html">
            <h1 class="capa">ProjManager</h1>
        </a>
    </header>

    <section class="projetos">
        <form method="get" action="projetos.php">
            <div>
                <label for="busca"><strong>Código do Projeto:</strong></label>
                <input type="text" id="busca" name="busca" required>
            </div>
            <div class="botao">
                <input type="submit" value="Buscar">
            </div>
        </form>
    </section>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Configurações do banco de dados
        include('../Banco de dados/conexao.php');

        try {
            // Conexão com o banco de dados
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Obter o valor do campo de busca
            $busca = $_GET['busca'];

            // Verificar se o valor é um número (código do projeto)
            if (preg_match('/^\d+$/', $busca)) {
                $idProjeto = $busca;
                $sql = "SELECT * FROM projetos WHERE idProjetos = :idProjeto";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':idProjeto', $idProjeto, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // Obter os dados do projeto
                    $projeto = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Preencher os campos do formulário com os dados do projeto
                    $nomeProjeto = $projeto['NomeProjeto'];
                    $verba = $projeto['verba'];
                    $valorGasto = $projeto['valorGasto'];
                    $descricao = $projeto['Descricao'];
                    $cliente_id = $projeto['Cliente_idCliente'];
                    $dataInicio = $projeto['DataInicio'];
                    $dataConclusao = $projeto['DataConclusao'];
                } else {
                    echo "Projeto não encontrado.";
                }
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
    ?>

    <h1>Cadastro Projeto</h1>
    <form action="salvarProjetos.php" method="post">
        <p class="Nome">Nome do Projeto:
            <input type="text" name="nome_projeto" required value="<?php echo isset($nomeProjeto) ? $nomeProjeto : ''; ?>">
        </p>
        <p class="verba">Verba:
            <input type="number" name="verba" min="0" required value="<?php echo isset($verba) ? $verba : ''; ?>">
        </p>
        <p class="valorg">Valor gasto:
            <input type="number" name="valor_gasto" min="0" required value="<?php echo isset($valorGasto) ? $valorGasto : ''; ?>">
        </p>
        <p class="desc">Descrição do Projeto:</p>
        <textarea name="descricao" id="descprojeto" cols="60" rows="15" required><?php echo isset($descricao) ? $descricao : ''; ?></textarea>
        <p class="nomec">Código Cliente:
            <input type="number" name="cliente_id" required value="<?php echo isset($cliente_id) ? $cliente_id : ''; ?>">
        </p>
        <p class="datecriacao">Data Criação:
            <input type="date" name="data_criacao" required value="<?php echo isset($dataInicio) ? $dataInicio : ''; ?>">
        </p>
        <p class="dateconclusao">Data Conclusão:
            <input type="date" name="data_conclusao" required value="<?php echo isset($dataConclusao) ? $dataConclusao : ''; ?>">
        </p>
        <p class="Salvar">
            <input type="submit" value="Salvar">
        </p>
    </form>
</body>
</html>
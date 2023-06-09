<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Colaborador - ProjManager</title>
    <link rel="stylesheet" href="ccolaborador style.css">n
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
    <section class="buscarColab" style="border: 1px solid #ddd; background-color: #f2f2f2; padding: 10px; margin: 90px;">
        <form method="get" action="ccolaborador.php">
            <div>
                <label for="busca"><strong>Código do Colaborador:</strong></label>
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

        // Verificar se o valor é um número (código do funcionário) ou um CPF/CNPJ
        if (preg_match('/^\d+$/', $busca)) {
            $cod_funcionario = $busca;
            $sql = "SELECT * FROM funcionario WHERE idFuncionario = :cod_funcionario";
        } else {
            $cpf_cnpj = $busca;
            $sql = "SELECT * FROM funcionario WHERE CPF_CNPJ = :cpf_cnpj";
        }

        $stmt = $conn->prepare($sql);

        if (isset($cod_funcionario)) {
            $stmt->bindParam(':cod_funcionario', $cod_funcionario, PDO::PARAM_INT);
        } elseif (isset($cpf_cnpj)) {
            $stmt->bindParam(':cpf_cnpj', $cpf_cnpj, PDO::PARAM_STR);
        }

        $stmt->execute();

        // Verificar se o funcionário foi encontrado
        if ($stmt->rowCount() > 0) {
            // Obter os dados do funcionário
            $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Preencher os campos do formulário com os dados do funcionário
            $nome = $funcionario['Nome'];
            $sobrenome = $funcionario['sobrenome'];
            $email = $funcionario['Email'];
            $emailCoorp = $funcionario['emailCoorp'];
            $cpf_cnpj = $funcionario['CPF_CNPJ'];
            $telefone = $funcionario['Telefone'];
            $endereco = $funcionario['Endereco'];
            $cep = $funcionario['CEP'];
            $bairro = $funcionario['bairro'];
            $cidade = $funcionario['cidade'];
            $numero = $funcionario['numero'];
            $uf = $funcionario['UF'];
            $complemento = $funcionario['Complemento'];

        } else {
            echo "Funcionário não encontrado.";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preencher os campos do formulário com os dados do cliente
        document.querySelector('input[name="nome"]').value = "<?php echo isset($nome) ? $nome : ''; ?>";
        document.querySelector('input[name="sobrenome"]').value = "<?php echo isset($sobrenome) ? $sobrenome : ''; ?>";
        document.querySelector('input[name="email"]').value = "<?php echo isset($email) ? $email : ''; ?>";
        document.querySelector('input[name="cpf_cnpj"]').value = "<?php echo isset($cpf_cnpj) ? $cpf_cnpj : ''; ?>";
        document.querySelector('input[name="telefone"]').value = "<?php echo isset($telefone) ? $telefone : ''; ?>";
        document.querySelector('input[name="cep"]').value = "<?php echo isset($cep) ? $cep : ''; ?>";
        document.querySelector('input[name="endereco"]').value = "<?php echo isset($endereco) ? $endereco : ''; ?>";
        document.querySelector('input[name="bairro"]').value = "<?php echo isset($bairro) ? $bairro : ''; ?>";
        document.querySelector('input[name="cidade"]').value = "<?php echo isset($cidade) ? $cidade : ''; ?>";
        document.querySelector('input[name="numero"]').value = "<?php echo isset($numero) ? $numero : ''; ?>";
        document.querySelector('select[name="uf"]').value = "<?php echo isset($uf) ? $uf : ''; ?>";
        document.querySelector('input[name="complemento"]').value = "<?php echo isset($complemento) ? $complemento : ''; ?>";
    });
</script>

<h1>Cadastro Colaborador</h1>
    <form action="salvarColab.php" method="post">
        <p class="Nome">Nome:
            <input type="text" name="nome" value="<?php echo isset($nome) ? $nome : ''; ?>" required>
        </p>
        <p class="LastName">Sobrenome:
            <input type="text" name="sobrenome" value="<?php echo isset($sobrenome) ? $sobrenome : ''; ?>" required>
        </p>
        <p class="Email">Email:
            <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
        </p>
        <p class="CPF">CPF/CNPJ:
            <input type="text" name="cpf_cnpj" value="<?php echo isset($cpf_cnpj) ? $cpf_cnpj : ''; ?>" required>
        </p>
        <p class="Telefone">Telefone:
            <input type="text" name="telefone" value="<?php echo isset($telefone) ? $telefone : ''; ?>" required>
        </p>
        <p class="CEP">CEP:
            <input type="text" name="cep" value="<?php echo isset($cep) ? $cep : ''; ?>" required>
        </p>
        <p class="Endereço">Endereço:
            <input type="text" name="endereco" value="<?php echo isset($endereco) ? $endereco : ''; ?>" required>
        </p>
        <p class="Bairro">Bairro:
            <input type="text" name="bairro" value="<?php echo isset($bairro) ? $bairro : ''; ?>" required>
        </p>
        <p class="Cidade">Cidade:
            <input type="text" name="cidade" value="<?php echo isset($cidade) ? $cidade : ''; ?>" required>
        </p>
        <p class="numero">Número:
            <input type="text" name="numero" value="<?php echo isset($numero) ? $numero : ''; ?>" required>
        </p>
        <p class="UF">UF:
            <select name="uf" required>
                <option value="">Selecione</option>
                <option value="AC" <?php echo isset($uf) && $uf === 'AC' ? 'selected' : ''; ?>>Acre</option>
                <option value="AL" <?php echo isset($uf) && $uf === 'AL' ? 'selected' : ''; ?>>Alagoas</option>
                <option value="AP" <?php echo isset($uf) && $uf === 'AP' ? 'selected' : ''; ?>>Amapá</option>
                <option value="AM" <?php echo isset($uf) && $uf === 'AM' ? 'selected' : ''; ?>>Amazonas</option>
                <option value="BA" <?php echo isset($uf) && $uf === 'BA' ? 'selected' : ''; ?>>Bahia</option>
                <option value="CE" <?php echo isset($uf) && $uf === 'CE' ? 'selected' : ''; ?>>Ceará</option>
                <option value="DF" <?php echo isset($uf) && $uf === 'DF' ? 'selected' : ''; ?>>Distrito Federal</option>
                <option value="ES" <?php echo isset($uf) && $uf === 'ES' ? 'selected' : ''; ?>>Espirito Santo</option>
                <option value="GO" <?php echo isset($uf) && $uf === 'GO' ? 'selected' : ''; ?>>Goiás</option>
                <option value="MA" <?php echo isset($uf) && $uf === 'MA' ? 'selected' : ''; ?>>Maranhão</option>
                <option value="MS" <?php echo isset($uf) && $uf === 'MS' ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                <option value="MT" <?php echo isset($uf) && $uf === 'MT' ? 'selected' : ''; ?>>Mato Grosso</option>
                <option value="MG" <?php echo isset($uf) && $uf === 'MG' ? 'selected' : ''; ?>>Minas Gerais</option>
                <option value="PA" <?php echo isset($uf) && $uf === 'PA' ? 'selected' : ''; ?>>Pará</option>
                <option value="PB" <?php echo isset($uf) && $uf === 'PB' ? 'selected' : ''; ?>>Paraíba</option>
                <option value="PR" <?php echo isset($uf) && $uf === 'PR' ? 'selected' : ''; ?>>Paraná</option>
                <option value="PE" <?php echo isset($uf) && $uf === 'PE' ? 'selected' : ''; ?>>Pernambuco</option>
                <option value="PI" <?php echo isset($uf) && $uf === 'PI' ? 'selected' : ''; ?>>Piauí</option>
                <option value="RJ" <?php echo isset($uf) && $uf === 'RJ' ? 'selected' : ''; ?>>Rio de Janeiro</option>
                <option value="RN" <?php echo isset($uf) && $uf === 'RN' ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                <option value="RS" <?php echo isset($uf) && $uf === 'RS' ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                <option value="RO" <?php echo isset($uf) && $uf === 'RO' ? 'selected' : ''; ?>>Rondônia</option>
                <option value="RR" <?php echo isset($uf) && $uf === 'RR' ? 'selected' : ''; ?>>Roraima</option>
                <option value="SC" <?php echo isset($uf) && $uf === 'SC' ? 'selected' : ''; ?>>Santa Catarina</option>
                <option value="SP" <?php echo isset($uf) && $uf === 'SP' ? 'selected' : ''; ?>>São Paulo</option>
                <option value="SE" <?php echo isset($uf) && $uf === 'SE' ? 'selected' : ''; ?>>Sergipe</option>
                <option value="TO" <?php echo isset($uf) && $uf === 'TO' ? 'selected' : ''; ?>>Tocantins</option>
            </select>
        </p>
        <p class="Complemento">Complemento:
            <input type="text" name="complemento" value="<?php echo isset($complemento) ? $complemento : ''; ?>">
        </p>
        <input type="submit" value="Salvar">
    </form>
</body>
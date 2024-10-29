<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'src/Database.php';
include_once 'src/Produto.php';

// Conectar ao banco de dados
$database = new DatabaseProdutos();
$db = $database->getConnection();

// Inicializar a classe Produto
$produto = new Produto($db);

// Inicializar variável para a mensagem
$message = '';

// Função para lidar com a criação de produtos
function handleCreate($produto) {
    if (isset($_POST['nome'])) {
        $produto->nome = $_POST['nome'];
        return $produto->create() ? "Produto criado com sucesso!" : "Erro ao criar produto.";
    }
    return '';
}

// Função para lidar com a exclusão de produtos
function handleDelete($produto) {
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $produto->id = $_POST['id'];
        return $produto->delete() ? "Produto excluído com sucesso!" : "Erro ao excluir produto.";
    }
    return '';
}

// Processar criação e exclusão
$message = handleCreate($produto) ?: handleDelete($produto);

// Listar os produtos
$produtos = $produto->readAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Produto</h1>

        <!-- Formulário para adicionar produto -->
        <form method="POST">
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" id="nome" required>
            <button type="submit">Adicionar</button>
        </form>

        <!-- Mensagem de sucesso ou erro -->
        <div class="message">
            <?php if ($message): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </div>

        <h2>Lista de Produtos</h2>
        <ul>
            <?php while ($row = $produtos->fetch(PDO::FETCH_ASSOC)): ?>
            <li>
                <?php echo htmlspecialchars($row['nome']); ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete">Excluir</button>
                </form>
            </li>
            <?php endwhile; ?>
        </ul>

    </div>
</body>
</html>

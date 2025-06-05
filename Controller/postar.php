<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require '../Model/conexao.php';

$mensagem_erro = '';
$mensagem_sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $texto = trim($_POST['texto']);
    $id_usuario = $_SESSION['usuario_id'];

    if (!empty($texto)) {
        $sql = "INSERT INTO publicacoes (id_usuario, texto, data_publicacao) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario, $texto]);

        header("Location: feed.php");
        exit();
    } else {
        $mensagem_erro = "A publicação não pode estar vazia.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Postar</title>
</head>
<body>
    <h2>O que está pensando?</h2>

    <?php if ($mensagem_erro): ?>
        <p style="color: red;"><?= htmlspecialchars($mensagem_erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="postar.php">
        <textarea name="texto" rows="5" cols="50" placeholder="Escreva aqui..."></textarea><br><br>
        <button type="submit">Postar</button>
    </form>

    <br>
    <a href="feed.php">🔙 Voltar ao Feed</a>
</body>
</html>

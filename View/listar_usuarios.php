<?php
include '../Model/conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT id, nickname FROM usuarios ORDER BY nickname ASC");
$usuarios = $stmt->fetchAll();
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<div class="menu">
    <a href="feed.php">Voltar ao Feed</a>
</div>

<div class="container">
    <h2>Pesquisar Usuários</h2>
    <?php foreach ($usuarios as $usuario): ?>
        <p><a href="ver_usuario.php?id=<?= $usuario['id'] ?>">@<?= htmlspecialchars($usuario['nickname']) ?></a></p>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>


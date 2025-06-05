
<?php
include '../Model/conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $nickname = $_POST['nickname'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $bio = $_POST['bio'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (email, nickname, senha, bio) VALUES (?, ?, ?, ?)");
    $stmt->execute([$email, $nickname, $senha, $bio]);

    header("Location: index.php");
    exit;
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<div class="container">
    <h1>Cadastro</h1>
    <form method="POST">
        <input type="email" name="email" placeholder="Seu e-mail" required>
        <input type="text" name="nickname" placeholder="Seu nickname" required>
        <input type="password" name="senha" placeholder="Sua senha" required>
        <textarea name="bio" placeholder="Sua bio (opcional)"></textarea>
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem uma conta? <a href="index.php">Faça login</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
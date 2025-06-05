<?php
session_start();
require '../Model/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não logado']);
    exit();
}

if (!isset($_POST['id_publicacao'])) {
    echo json_encode(['success' => false, 'message' => 'Publicação inválida']);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$id_publicacao = intval($_POST['id_publicacao']);

// Verificar se já curtiu o post
$stmt = $pdo->prepare("SELECT id FROM curtidas WHERE id_usuario = ? AND id_publicacao = ?");
$stmt->execute([$usuario_id, $id_publicacao]);
$existe = $stmt->fetch();

if ($existe) {
    // Se já curtiu, remove a curtida (toggle)
    $stmt = $pdo->prepare("DELETE FROM curtidas WHERE id = ?");
    $stmt->execute([$existe['id']]);
    $curtiu = false;
} else {
    // Se não curtiu, adiciona
    $stmt = $pdo->prepare("INSERT INTO curtidas (id_usuario, id_publicacao) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $id_publicacao]);
    $curtiu = true;
}

// Contar total de curtidas no post agora
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM curtidas WHERE id_publicacao = ?");
$stmt->execute([$id_publicacao]);
$total = $stmt->fetch()['total'];

echo json_encode(['success' => true, 'curtiu' => $curtiu, 'total' => $total]);

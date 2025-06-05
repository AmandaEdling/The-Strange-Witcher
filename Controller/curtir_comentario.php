<?php
session_start();
'../Model/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não logado']);
    exit();
}

if (!isset($_POST['id_comentario'])) {
    echo json_encode(['success' => false, 'message' => 'Comentário inválido']);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$id_comentario = intval($_POST['id_comentario']);

// Verificar se já curtiu
$stmt = $pdo->prepare("SELECT id FROM curtidas_comentarios WHERE id_usuario = ? AND id_comentario = ?");
$stmt->execute([$usuario_id, $id_comentario]);
$existe = $stmt->fetch();

if ($existe) {
    // Se já curtiu, remove a curtida (toggle)
    $stmt = $pdo->prepare("DELETE FROM curtidas_comentarios WHERE id = ?");
    $stmt->execute([$existe['id']]);
    $curtiu = false;
} else {
    // Se não curtiu, adiciona
    $stmt = $pdo->prepare("INSERT INTO curtidas_comentarios (id_usuario, id_comentario) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $id_comentario]);
    $curtiu = true;
}

// Contar quantas curtidas tem agora
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM curtidas_comentarios WHERE id_comentario = ?");
$stmt->execute([$id_comentario]);
$total = $stmt->fetch()['total'];

echo json_encode(['success' => true, 'curtiu' => $curtiu, 'total' => $total]);

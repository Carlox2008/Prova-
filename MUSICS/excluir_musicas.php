<?php
include("../conexao.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $con->prepare("
        DELETE m, g, c 
        FROM musicas m
        INNER JOIN galeria g ON m.id = g.musicas_id
        INNER JOIN catalogo_musica c ON g.catalogo_id = c.id
        WHERE m.id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: listarM.php");
exit();

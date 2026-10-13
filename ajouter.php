<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $priorite = $_POST['priorite'] ?? '';

    if (!is_string($titre) || !is_string($priorite)) {
        exit('Données invalides.');
    }

    $titre = trim($titre);

    if ($titre === '') {
        exit('Le titre est obligatoire.');
    }

    if (!in_array($priorite, ['haute', 'moyenne', 'basse'], true)) {
        exit('La priorité est invalide.');
    }

    $sql = 'INSERT INTO taches (titre, priorite, terminee)
            VALUES (?, ?, 0)';
    $requete = $pdo->prepare($sql);
    $requete->execute([$titre, $priorite]);

    header('Location: index.php');
    exit;
}
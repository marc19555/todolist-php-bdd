<?php
// __DIR__ désigne le dossier de ce fichier, quel que soit le dossier de lancement.
require __DIR__ . '/donnees.php';
require __DIR__ . '/fonctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = 'INSERT INTO taches (titre, priorite, terminee)
            VALUES (?, ?, 0)';
    $requete = $pdo->prepare($sql);
    $requete->execute([$_POST['titre'], $_POST['priorite']]);

    header('Location: index.php');
    exit;
}


$titrePage = 'Ma liste de tâches';
$total = count($taches);
$restantes = compterTachesRestantes($taches);
$terminees = $total - $restantes;

include __DIR__ . '/includes/entete.php';
?>

<section class="statistiques" aria-label="Résumé des tâches">
    <div><strong><?= $total ?></strong><span>Au total</span></div>
    <div><strong><?= $restantes ?></strong><span>À faire</span></div>
    <div><strong><?= $terminees ?></strong><span>Terminées</span></div>
</section>

<section class="liste" aria-labelledby="titre-liste">
    <h2 id="titre-liste">Mes tâches</h2>
    <?php if (empty($taches)): ?>
        <p class="message">Aucune tâche pour le moment.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($taches as $tache): ?>
                <li class="tache <?= $tache['terminee'] ? 'terminee' : '' ?>">
                    <div>
                        <h3><?= echapper($tache['titre']) ?></h3>
                        <p>Priorité : <?= echapper(libellePriorite($tache['priorite'])) ?></p>
                    </div>
                    <span class="etat"><?= $tache['terminee'] ? 'Terminée' : 'À faire' ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($restantes === 0): ?>
            <p class="message">Bravo, toutes les tâches sont terminées !</p>
        <?php endif; ?>
    <?php endif; ?>
</section>
<section class="task-form-section">
    <h2>Ajouter une tâche</h2>
    <form method="POST">
        
        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" maxlength="255" required placeholder="Saisir le titre de la tâche">
        </div>

        <div class="form-group">
            <label for="priorite">Priorité :</label>
            <select id="priorite" name="priorite" required>
                <option value="facile">Facile</option>
                <option value="moyen" selected>Moyen</option>
                <option value="difficile">Difficile</option>
            </select>
        </div>
        <button type="submit">Enregistrer</button>
    </form>
</section>

<?php include __DIR__ . '/test_connexion.php';?>
<?php include __DIR__ . '/includes/pied.php'; ?>

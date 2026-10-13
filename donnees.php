<?php

require __DIR__ . '/connexion.php';


$requete = $pdo->query(
   'SELECT id, titre, priorite, terminee FROM taches'
);
$taches = $requete->fetchAll();
<?php

require(DOC_ROOT_PATH . '/models/competences.php');
require(DOC_ROOT_PATH . '/views/credits-modal.php');

// Affiche l'accueil du site
function accueil() {
    $competences = getCompetences();
    $competencesValidees = getCompetencesValides();
    require(DOC_ROOT_PATH . '/views/index.php');
}

// Permet de gerer les competences
function gestionCompetences() {
    $competences = getToutesLesCompetences();
    require(DOC_ROOT_PATH . '/views/tableau-de-bord/gestion-competences.php');
}

// Permet de valider des competences pour un tuteur
function validerCompetencesUtilisateurs() {
    $competences = getToutesLesCompetences();
    require(DOC_ROOT_PATH . '/views/tableau-de-bord/valider-competences-utilisateurs.php');
}

// Affiche une erreur
function erreur($msgErreur) {
    require(DOC_ROOT_PATH . '/views/erreur.php');
}

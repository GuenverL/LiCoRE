<?php

require(DOC_ROOT_PATH . '/models/competences.php');
require(DOC_ROOT_PATH . '/models/session.php');
require(DOC_ROOT_PATH . '/views/credits-modal.php');

// Affiche l'accueil du site
function accueil() {
    require(DOC_ROOT_PATH . '/views/accueil/index.php');
}

// Permet de gerer les competences
function gestionCompetences() {
    require(DOC_ROOT_PATH . '/views/tableau-de-bord/gestion-competences.php');
}

// Permet de valider des competences pour un tuteur
function validerCompetencesUtilisateurs() {
    require(DOC_ROOT_PATH . '/views/tableau-de-bord/valider-competences-utilisateurs.php');
}

function connexion() {
    require(DOC_ROOT_PATH . '/models/connexion.php');
    require(DOC_ROOT_PATH . '/views/connexion.php');
}

function deconnexion() {
    require(DOC_ROOT_PATH . '/models/deconnexion.php');
}

// Affiche une erreur
function erreur($msgErreur) {
    require(DOC_ROOT_PATH . '/views/erreur.php');
}

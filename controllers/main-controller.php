<?php

require(DOC_ROOT_PATH . '/models/competences.php');

// Affiche l'accueil du site
function accueil() {
  $competences = getCompetences();
  $competencesValidees = getCompetencesValides();
  require(DOC_ROOT_PATH . '/views/index.php');
}

// Permet d'ajouter une competence
function gestionCompetences() {
  require(DOC_ROOT_PATH . '/views/tableau-de-bord/gestion-competences.php');
}

// Affiche une erreur
function erreur($msgErreur) {
  require(DOC_ROOT_PATH . '/views/erreur.php');
}

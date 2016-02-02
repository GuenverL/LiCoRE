<?php

require(DOC_ROOT_PATH . '/models/competences.php');

// Affiche l'accueil du site
function accueil() {
  $competences = getCompetences();
  require(DOC_ROOT_PATH . '/views/index.php');
}

// Affiche l'accueil du site
function ajouterCompetence() {
  require(DOC_ROOT_PATH . '/views/tableau-de-bord/ajouter-competence.php');
}

// Affiche une erreur
function erreur($msgErreur) {
  require(DOC_ROOT_PATH . '/views/erreur.php');
}

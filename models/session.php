<?php

function estConnecte() {
  return isset($_SESSION['idUtilisateur']);
}

function getIdUtilisateur() {
  return $_SESSION['idUtilisateur'];
}

function getPrenomUtilisateur() {
  return $_SESSION['prenom'];
}

function getNomUtilisateur() {
  return $_SESSION['nom'];
}

?>

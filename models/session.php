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

function getRoleUtilisateur() {
  return $_SESSION['role'];
}

function estAccessible($page) {
  if(estConnecte()) {
    if((isset($_SESSION['acces']) && (in_array($page, $_SESSION['acces'])))) {
      return true;
    }
  }
  return false;
}

?>

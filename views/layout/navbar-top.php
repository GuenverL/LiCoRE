<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Projet Licore</a>
    </div>

    <ul id="navbar-ul" class="nav navbar-nav">
      <li id="navbar-mes-competences">
        <a href="index.php">Mes compétences</a>
      </li>
      <?php
        if (estAccessible('valider-competences-utilisateurs')) {
          echo '<li id="navbar-valider-competences-utilisateurs"><a href="index.php?action=valider-competences-utilisateurs">Valider des compétences</a></li>';
        }
        if (estAccessible('gestion-competences')) {
          echo '<li id="navbar-gestion-competences"><a href="index.php?action=gestion-competences">Gestion des compétences</a></li>';
        }
        ?>
      </ul>
    </ul>

    <div class="navbar-right">
      <?php
        if (estConnecte()) {
          echo 'Connecté sous le nom « ' . getPrenomUtilisateur() . ' ' . getNomUtilisateur() . ' » ';
          echo '(<a href="index.php?action=deconnexion">Déconnexion</a>)';
        } else {
          echo '<a href="index.php?action=connexion"><button type="button" class="btn btn-default navbar-btn">Connexion</button></a>';
        }
      ?>
    </div>

  </div>
</nav>

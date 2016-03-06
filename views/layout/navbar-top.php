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

    <ul class="nav navbar-nav">
      <li class="active">
        <a href="index.php">Accueil</a>
      </li>
    </ul>

    <div class="navbar-right">

      <?php if ((estAccessible('gestion-competences')) || (estAccessible('valider-competences-utilisateurs'))) { ?>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tableau de bord
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <?php
              if (estAccessible('gestion-competences')) {
                echo '<li><a href="index.php?action=gestion-competences">Gestion des compétences</a></li>';
              }
              if (estAccessible('valider-competences-utilisateurs')) {
                echo '<li><a href="index.php?action=valider-competences-utilisateurs">Valider des compétences</a></li>';
              }
            ?>
          </ul>
        </div>
      <?php } ?>

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

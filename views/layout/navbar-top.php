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
            <li class="active"><a href="index.php">Accueil</a></li>
        </ul>

        <div class="navbar-right">

            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tableau de bord <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="index.php?action=gestion-competences">Gestion des compétences</a></li>
                    <li><a href="index.php?action=valider-competences-utilisateurs">Valider des compétences</a></li>
                </ul>
            </div>

            <button type="button" class="btn btn-default navbar-btn">Connexion</button>
        </div>

    </div>
</nav>

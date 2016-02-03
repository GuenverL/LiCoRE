<?php

function afficherArbreGestionCompetences($parent, $niveau, $array) {
    $html = "";
    $niveau_precedent = 0;

    if (!$niveau && !$niveau_precedent) {
        $html .= "\n<ul>\n";
    }

     foreach ($array AS $noeud) {
        if ($parent == $noeud['idPereCompetence']) {
            if ($niveau_precedent < $niveau) {
                $html .= "\n<ul>\n";
            }

            $html .= '<li><a href="#">' . $noeud['nomCompetence'] . '</a>';

            $html .= ' <span data-toggle="modal" data-target="#ajouterCompetenceModal" data-id-pere="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-plus cursor-pointer" aria-hidden="true"></span>';

            $html .= ' <span data-toggle="modal" data-target="#modifierCompetenceModal" data-id-competence="' . $noeud['idCompetence'] . '" data-nom-competence="' . $noeud['nomCompetence'] . '" class="glyphicon glyphicon-pencil cursor-pointer" aria-hidden="true"></span>';

            $niveau_precedent = $niveau;
            $html .= afficherArbreGestionCompetences($noeud['idCompetence'], ($niveau + 1), $array);
        }
    }

    if (($niveau_precedent == $niveau) && ($niveau_precedent != 0)) {
        $html .= "</ul>\n</li>\n";
    }
    else if ($niveau_precedent == $niveau) {
        $html .= "</ul>\n";
    }
    else {
        $html .= "</li>\n";
    }

    return $html;
}
?>

<?php $titre = 'Gestion des compétences'; ?>

<?php require(DOC_ROOT_PATH . '/views/tableau-de-bord/ajouter-competence.php'); ?>
<?php require(DOC_ROOT_PATH . '/views/tableau-de-bord/modifier-competence.php'); ?>

<?php ob_start(); ?>
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                Gestion des compétences
            </div>

            <div class="panel-body">
                <ul class="treeview">
                    <li><a href="#">Liste des compétences</a>
                        <?php echo afficherArbreGestionCompetences(0,0,$competences); ?>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>

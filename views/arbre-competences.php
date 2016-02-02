<div class="panel panel-default">
    <div class="panel-heading">
        Arbre des compétences validées
    </div>

    <div class="panel-body">
        <?php
            if(!empty($competencesValidees)) {
                echo '<ul class="treeview">
                    <li><a href="#">Liste des compétences validées</a>';
                echo afficherArbreCompetences(0,0,$competencesValidees);
                echo '</li></ul>';
            }
            else {
                echo '<p>Aucunes compétences validées</p>';
            }
        ?>
    </div>
</div>

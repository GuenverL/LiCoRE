<div class="panel panel-default">
    <div class="panel-heading">
        Arbre des compétences validées
    </div>

    <div class="panel-body">
        <?php
            if(isset($competencesValidees)) {
                echo afficherArbreCompetences(0,0,$competencesValidees);
            }
            else {
                echo '<p>Aucunes compétences validées</p>';
            }
        ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
                Arbre des compétences validées
                <div class="btn-group">
                    <button type ="button" id="btnExport" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        export <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="linkXML" download="tree.xml" href="#">XML</a></li>
                        <li><a id="btnPDF"  download="tree.pdf" href="#">PDF</a></li>
                    </ul>
                </div>
    </div>

    <div class="panel-body">
        <?php
            if(!empty($competencesValidees)) {
                echo '<ul id="arbre" class="treeview">
                    <li><a href="#">Liste des compétences validées</a>';
                echo afficherArbreCompetences(0,0,$competencesValidees,'afficherCompetences');
                echo '</li></ul>';
            }
            else {
                echo '<p>Aucunes compétences validées</p>';
            }
        ?>
    </div>
</div>

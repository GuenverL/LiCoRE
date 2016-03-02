<div class="panel panel-default">
   <div class="panel-heading">
            Arbre des compétences validées
            <div class="btn-group">
                <button type ="button" id="btnExport" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    export <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a id="linkXML" download="tree.xml" href="#">XML</a></li>
                    <li><a id="btnPDF" target="_blank" href="views/pdf.php">PDF</a></li>
                </ul>
            </div>
            <span id="toggleFullscreenCompetencesValidees" class=" glyphicon glyphicon-resize-full cursor-pointer"
            data-toggle="tooltip" data-placement="top" title="Mettre la colonne des compétences validées en plein écran" aria-hidden="true"></span>
    </div>

    <div id="panel-body-competences-validees" class="panel-body">
      <ul id="arbreListeCompetencesValidees" class="treeview"></ul>
    </div>

</div>

<?php ob_start(); ?>
  <script>
    $('#toggleFullscreenCompetencesValidees').click(function(){
        if ($('#col-competences-validees').hasClass('col-md-4')){
            $('#col-liste-competences').css({
                display: "none"
            });
            $('#col-competences-a-valider').css({
                display: "none"
            });
            $('#toggleFullscreenCompetencesValidees').attr('data-original-title', 'Quitter le mode plein écran');
        } else {
            $('#col-liste-competences').css({
                display: "block"
            });
            $('#col-competences-a-valider').css({
                display: "block"
            });
            $('#toggleFullscreenCompetencesValidees').attr('data-original-title', 'Mettre la colonne des compétences validées en plein écran');
        }

        $('#col-competences-validees').toggleClass('col-md-4');
        $('#col-competences-validees').toggleClass('col-md-12');
        $('#toggleFullscreenCompetencesValidees').toggleClass('glyphicon-resize-full');
        $('#toggleFullscreenCompetencesValidees').toggleClass('glyphicon-resize-small');
    });
    $('[data-toggle="tooltip"]').tooltip();
  </script>
<?php $scripts = ob_get_clean(); ?>

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
    </div>

    <div id="panel-body-competences-validees" class="panel-body">
      <ul id="arbreListeCompetencesValidees" class="treeview"></ul>
    </div>

</div>

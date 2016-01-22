<div class="panel panel-default">
    <div class="panel-heading">Compétences à valider
    </div>
    <div class="panel-body">
        <div class="list-group">
            <?php echo afficherCompetencesAValider() ?>
            <div class="list-group-item btn" onclick="validation(this)">
                <label >                                sous-compétence 1-2
                </label>
            </div>
            <div class="list-group-item btn" onclick="validation(this)">
                <label >                                sous-compétence 2-1
                </label>
            </div>
            <div class="list-group-item btn" onclick="validation(this)">
                <label >                                sous-compétence 2-2
                </label>
            </div>
        </div>
    </div>
</div>
<?php
function afficherCompetencesAValider() {
    $html = "";
    $html .= "<div class=\"list-group-item btn\" onclick=\"validation(this)\">\n";
    $html .= "<label >sous-compétence\n";
    $html .= "</label>\n";
    $html .= "</div>\n";
    return $html;
}?>
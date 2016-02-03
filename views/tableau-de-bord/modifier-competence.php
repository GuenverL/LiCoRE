<div class="modal fade" id="modifierCompetenceModal" tabindex="-1" role="dialog" aria-labelledby="modifierCompetenceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Annuler"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modifierCompetenceModalLabel">Modifier la compétence</h4>
            </div>
            <div class="modal-body">
                <form action="modifier-competence-form.php" method="post">
                    <div class="form-group">
                        <label for="id-competence" class="control-label">Id :</label>
                        <input type="text" class="form-control" id="idCompetence" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nom-competence" class="control-label">Nom :</label>
                        <input type="text" class="form-control" id="nomCompetence">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="index.php?action=gestion-competences"><button type="button" class="btn btn-primary" id="submit">Sauvegarder</button></a>
            </div>
        </div>
    </div>
</div>

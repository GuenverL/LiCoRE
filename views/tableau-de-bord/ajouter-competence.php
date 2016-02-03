<div class="modal fade" id="ajouterCompetenceModal" tabindex="-1" role="dialog" aria-labelledby="ajouterCompetenceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Annuler"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ajouterCompetenceModalLabel">Ajouter une compétence</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="id-pere" class="control-label">Id pere :</label>
                        <input type="text" class="form-control" id="idPere" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nom-competence" class="control-label">Nom de la nouvelle compétence :</label>
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

<div class="modal fade" id="ajouterPlusieursCompetencesModal" tabindex="-1" role="dialog" aria-labelledby="ajouterPlusieursCompetencesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Annuler"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ajouterPlusieursCompetencesModalLabel">Ajouter des compétences</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="nom-competence" class="control-label">Nom des nouvelles compétences (séparée par un retour à la ligne) :</label>
                        <textarea rows="20" class="form-control" id="nomsCompetences"></textarea>
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

$('#ajouterCompetenceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idPere = button.data('id-pere') // Extract info from data-* attributes
    var nomCompetence = button.data('nom-competence')

    var modal = $(this)
    modal.find('.modal-title').text('Ajouter une sous compétence à "' + nomCompetence + '"')
    modal.find('.modal-body #idPere').val(idPere)

    $("button#submit").click(function() {
        $.getJSON('api/competences.php', {
            type: 'ajouterCompetence',
            idPere: idPere,
            nomCompetence: modal.find('.modal-body #nomCompetence').val()
        });
    });
})

$('#modifierCompetenceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCompetence = button.data('id-competence') // Extract info from data-* attributes
    var nomCompetence = button.data('nom-competence')

    var modal = $(this)
    modal.find('.modal-title').text('Modifier la compétence "' + nomCompetence + '"')
    modal.find('.modal-body #idCompetence').val(idCompetence)
    modal.find('.modal-body #nomCompetence').val(nomCompetence)

    $("button#submit").click(function() {
        $.getJSON('api/competences.php', {
            type: 'modifierCompetence',
            idCompetence: idCompetence,
            nomCompetence: modal.find('.modal-body #nomCompetence').val()
        });
    });
})

$('#supprimerCompetenceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCompetence = button.data('id-competence') // Extract info from data-* attributes
    var nomCompetence = button.data('nom-competence')
    var feuille = button.data('feuille')

    var modal = $(this)
    modal.find('.modal-body #idCompetence').val(idCompetence)
    modal.find('.modal-body #nomCompetence').val(nomCompetence)
    modal.find('#modal-suppr').empty()
    if(feuille){
        modal.find('.modal-title').text('Supprimer la compétence "' + nomCompetence + '"')
        modal.find('#modal-suppr').append('<h2>ATTENTION !</h2>'+
        '<h3>Voulez-vous vraiment continuer et supprimer cette compétence ?</h3>')
    }else{
        modal.find('.modal-title').text('Supprimer la catégorie "' + nomCompetence + '"')
        modal.find('#modal-suppr').append('<h2>ATTENTION !</h2>'+
        '<h3>La suppression de cette catégorie entrainera la suppression de toutes ses sous-catégories et compétences </h3>'+
        '<h3>Voulez-vous vraiment continuer et supprimer cette catégorie ?</h3>')
    }

    $("button#submit").click(function() {
        $.getJSON('api/competences.php', {
            type: 'supprimerCompetence',
            idCompetence: idCompetence,
            nomCompetence: modal.find('.modal-body #nomCompetence').val()
        });
    });
})

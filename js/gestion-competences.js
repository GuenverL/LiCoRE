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
            nomCompetence: document.getElementById('nomCompetence').value
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
            nomCompetence: document.getElementById('nomCompetence').value
        });
    });
})

$('#supprimerCompetenceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCompetence = button.data('id-competence') // Extract info from data-* attributes
    var nomCompetence = button.data('nom-competence')

    var modal = $(this)
    modal.find('.modal-title').text('Supprimer la compétence "' + nomCompetence + '"')
    modal.find('.modal-body #idCompetence').val(idCompetence)
    modal.find('.modal-body #nomCompetence').val(nomCompetence)

    $("button#submit").click(function() {
        $.getJSON('api/competences.php', {
            type: 'supprimerCompetence',
            idCompetence: idCompetence,
            nomCompetence: document.getElementById('nomCompetence').value
        });
    });
})

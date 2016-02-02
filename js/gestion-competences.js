$('#modifierCompetenceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCompetence = button.data('id-competence') // Extract info from data-* attributes
    var nomCompetence = button.data('nom-competence')

    var modal = $(this)
    modal.find('.modal-title').text('Modifier la compétence "' + nomCompetence + '"')
    modal.find('.modal-body input').val(idCompetence)
    modal.find('.modal-body input').val(nomCompetence)
})

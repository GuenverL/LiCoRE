function validation(button) {
    button.style.background = "#5cb85c";
}

function afficherCompetence(id) {
    $.getJSON('api/competences.php', {
            type: 'sousCompetences',
            idPere: id
        },
        function(competences) {
            $("#competences-a-valider").empty();
            for (competence of competences) {

                $("#competences-a-valider").append('<div class="list-group-item" onclick="validation(' + competence.id + ')">' +
                    '<label>' + competence.nom + '</label>' +
                    '</div>');
            }
        }
    );
}

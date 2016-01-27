function validation(button,id) {
    button.style.background = "#5cb85c";
    //<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
}

function afficherCompetence(id) {
    $.getJSON('api/competences.php', {
            type: 'sousCompetences',
            idPere: id
        },
        function(competences) {
            $("#competences-a-valider").empty();
            for (competence of competences) {

                $("#competences-a-valider").append('<div class="list-group-item" onclick="validation(this,' + competence.id + ')">' +
                    '<label>' + competence.nom + '</label>' +
                    '</div>');
            }
        }
    );
}

function validation(button,id) {
    if(button.className == "list-group-item"){
        button.style.background = "#5cb85c";
        button.className += " validated"
    }else{
        button.style.background = "#ffffff";
        button.className = "list-group-item"
    }
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

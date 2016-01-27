
function validation(button,id) {
    id="idComp"+id
    span=document.getElementById(id)

    if(button.className == "list-group-item"){
        button.style.background = "#5cb85c";
        button.className += " validated"
        span.className="glyphicon glyphicon-remove"

    }else{
        button.style.background = "#ffffff";
        button.className = "list-group-item";
        span.className="glyphicon glyphicon-ok"
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

                $("#competences-a-valider").append('<div class="list-group-item" onclick="validation(this,' + competence.id + ')">'+
                    '<div class="media"><div class="media-body">' +
                        competence.nom +
                    '</div><div class="media-right media-middle"><span id="idComp'+competence.id+'" class="glyphicon glyphicon-ok" aria-hidden="true"><span></div></div>' +
                '</div>');
            }
        }
    );
}


function validation(button,id) {
    id="idComp"+id
    span=document.getElementById(id)

    if(button.className == "list-group-item"){
        button.style.background = "#d9ffd9";
        button.className += " validated"
        span.className="glyphicon glyphicon-remove"

    }else{
        button.style.background = "#ffffff";
        button.className = "list-group-item";
        span.className="glyphicon glyphicon-ok"
    }
}

var lienPrecedent = null;
function afficherCompetence(lien,id) {

    if(lienPrecedent != null) {
        lienPrecedent.style.color = "#336699";
        lienPrecedent = lien;
    }
    lienPrecedent = lien;
    lien.style.color = "#e5512b";
    
    $.getJSON('api/competences.php', {
            type: 'sousCompetences',
            idPere: id
        },
        function(competences) {
            $("#panel-body-competences").empty();
            $("#panel-body-competences").append('nomCompetence : <div id="competences-a-valider" class="list-group"></div>');
            for (competence of competences) {

                $("#competences-a-valider").append('<div class="list-group-item" onclick="validation(this,' + competence.id + ')">'+
                    '<div class="media"><div class="media-body">' +
                        competence.nom +
                    '</div><div class="media-right media-middle"><span id="idComp'+competence.id+'" class="glyphicon glyphicon-ok" aria-hidden="true"></span></div></div>' +
                '</div>');
            }
        }).fail( function(competences, textStatus, error) {
            console.error("getJSON failed, status: " + textStatus + ", error: "+error)
        });
}

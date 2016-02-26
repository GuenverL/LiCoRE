function validationCompetenceUtilisateur(button,idCompetence, idUtilisateur) {

    span=document.getElementById("idUtilisateur" + idUtilisateur);

    if(button.className == "list-group-item cursor-pointer") {
        button.style.background = "rgb(142, 188, 62)";
        button.className += " validated";
        span.className="glyphicon glyphicon-remove";
        validerCompetenceUtilisateur(idCompetence,idUtilisateur);
    }
    else {
        button.style.background = "#ffffff";
        button.className = "list-group-item cursor-pointer";
        span.className="glyphicon glyphicon-ok";
        invaliderCompetenceUtilisateur(idCompetence,idUtilisateur);
    }
}

function validerCompetenceUtilisateur(idCompetence,idUtilisateur){
    $.getJSON('api/competences.php', {
            type: 'validationCompetencesUtilisateurs',
            idCompetence: idCompetence,
            idUtilisateur: idUtilisateur
        });
}

function invaliderCompetenceUtilisateur(idCompetence,idUtilisateur){
    $.getJSON('api/competences.php',{
            type: 'invalidationCompetencesUtilisateurs',
            idCompetence: idCompetence,
            idUtilisateur: idUtilisateur
        });
}

var lienPrecedent = null;
function afficherUtilisateursCompetence(lien,idCompetence){

    if(lienPrecedent != null){
        lienPrecedent.style.color = "rgb(34, 68, 238)";
    }
    lienPrecedent = lien;
    lienPrecedent.style.color = "rgb(229, 81, 43)";

    $.getJSON('api/competences.php',{
            type: 'getUtilisateursCompetence',
            idCompetence: idCompetence
        },
        function(utilisateurs) {
            $("#panel-body-etudiants").empty();
            $("#panel-body-etudiants").append('<div class="list-group-item heading">'
            + lien.innerHTML +
            '</div> <div id="utilisateurs-a-valider" class="list-group"></div>');
            for (utilisateur of utilisateurs){
                if(utilisateur.valide) {
                    $("#utilisateurs-a-valider").append('<div class="list-group-item validated cursor-pointer" onclick="validationCompetenceUtilisateur(this,' + idCompetence + ',' + utilisateur.idUtilisateur + ')" style="background-color: rgb(142, 188, 62)">'+
                        '<div class="media"><div class="media-body">'
                            + utilisateur.prenom + ' ' + utilisateur.nom +
                        '</div><div class="media-right media-middle"><span id="idUtilisateur'+utilisateur.idUtilisateur+'" class="glyphicon glyphicon-remove" aria-hidden="true"></span></div></div>' +
                    '</div>');
                }
                else {
                    $("#utilisateurs-a-valider").append('<div class="list-group-item cursor-pointer" onclick="validationCompetenceUtilisateur(this,' + idCompetence + ',' + utilisateur.idUtilisateur + ')">'+
                        '<div class="media"><div class="media-body">'
                            + utilisateur.prenom + ' ' + utilisateur.nom +
                        '</div><div class="media-right media-middle"><span id="idUtilisateur'+utilisateur.idUtilisateur+'" class="glyphicon glyphicon-ok" aria-hidden="true"></span></div></div>' +
                    '</div>');
                }
            }
        }).fail( function(utilisateurs, textStatus, error){
            console.error("getJSON failed, status: " + textStatus + ", error: "+error)
        });
}

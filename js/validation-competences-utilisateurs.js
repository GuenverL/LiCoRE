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
        lienPrecedent.style.color = "rgb(51, 102, 153)";
    }
    lienPrecedent = lien;
    lienPrecedent.style.color = "rgb(229, 81, 43)";

    $("#panel-body-etudiants").empty();
    $("#panel-body-etudiants").append('<div class="list-group-item" style="background-color: #81c0c4">'+lien.innerHTML+'</div> <div id="competences-a-valider" class="list-group"></div>');
    for (competence of competences){
        if(competence.valide == true){
            $("#competences-a-valider").append('<div class="list-group-item validated cursor-pointer" onclick="validation(this,' + competence.id + ')" style="background-color: #d9ffd9">'+
                '<div class="media"><div class="media-body">' +
                    competence.nom +
                '</div><div class="media-right media-middle"><span id="idComp'+competence.id+'" class="glyphicon glyphicon-remove" aria-hidden="true"></span></div></div>' +
            '</div>');
        }else{
            $("#competences-a-valider").append('<div class="list-group-item cursor-pointer" onclick="validation(this,' + competence.id + ')">'+
                '<div class="media"><div class="media-body">' +
                    competence.nom +
                '</div><div class="media-right media-middle"><span id="idComp'+competence.id+'" class="glyphicon glyphicon-ok" aria-hidden="true"></span></div></div>' +
            '</div>');
        }
    }
}

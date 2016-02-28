function validation(button, id) {
  idCompetence = "idComp" + id
  span = document.getElementById(idCompetence)

  if (button.className == "list-group-item cursor-pointer") {
    button.style.background = "rgb(142, 188, 62)";
    button.className += " validated";
    span.className = "glyphicon glyphicon-remove";
    validerCompetence(id);
  } else {
    button.style.background = "#ffffff";
    button.className = "list-group-item cursor-pointer";
    span.className = "glyphicon glyphicon-ok";
    invaliderCompetence(id);
  }
}

function validerCompetence(id) {
  $.getJSON('api/competences.php', {
    type: 'validation',
    idCompetence: id
  });
}

function invaliderCompetence(id) {
  $.getJSON('api/competences.php', {
    type: 'invalidation',
    idCompetence: id
  });
}

var lienPrecedent = null;

function afficherCompetence(lien, id) {

  if (lienPrecedent !== null) {
    lienPrecedent.style.color = 'rgb(34, 68, 238)';
  }
  lienPrecedent = lien;
  lienPrecedent.style.color = 'rgb(232, 85, 36)';

  $.getJSON('api/competences.php', {
      type: 'sousCompetences',
      idPere: id,
    },
    function (competences) {
      $('#panel-body-competences').empty();
      $('#panel-body-competences').append('<div class="list-group-item heading">' + lien.innerHTML + '</div> <div id="competences-a-valider" class="list-group"></div>');
      for (var competence of competences) {
        if (competence.valide == true) {
          $('#competences-a-valider').append('<div class="list-group-item validated cursor-pointer" onclick="validation(this,' +
            competence.id + ')" style="background-color: rgb(142, 188, 62)">' +
            '<div class="media"><div class="media-body">' +
            competence.nom +
            '</div><div class="media-right media-middle"><span id="idComp' + competence.id +
            '" class="glyphicon glyphicon-remove" aria-hidden="true"></span></div></div>' +
            '</div>');
        } else {
          $('#competences-a-valider').append('<div class="list-group-item cursor-pointer" onclick="validation(this,' + competence.id + ')">' +
            '<div class="media"><div class="media-body">' +
            competence.nom +
            '</div><div class="media-right media-middle"><span id="idComp' + competence.id +
            '" class="glyphicon glyphicon-ok" aria-hidden="true"></span></div></div>' +
            '</div>');
        }
      }
    }).fail(function(competences, textStatus, error) {
    console.error('getJSON failed, status: ' + textStatus + ', error: ' + error);
  });
}

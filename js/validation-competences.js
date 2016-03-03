function genererListGroupItem(competence, couleurbg, type, classGlyphicon) {
  'use strict';

  var html = '';

  html = '<div class="list-group-item cursor-pointer couleur-' + couleurbg +
    '-bg" data-toggle="modal" data-target="#genericModal" data-type="' + type +
    '" data-id-competence="' + competence.id + '" data-nom-competence="' + competence.nom + '">' +
    '<div class="media">' +
    '<div class="media-body">' +
    competence.nom +
    '</div>' +
    '<div class="media-right media-middle">' +
    '<span id="idComp' + competence.id + '" class="glyphicon ' + classGlyphicon + '" aria-hidden="true">' +
    '</span>' +
    '</div>' +
    '</div>' +
    '</div>';

  return html;
}

function buttonSubmitValidation(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
  var nomCompetence = event.data.nomCompetence;
  var type = event.data.type;

  var competenceObject = {
    idCompetence: idCompetence,
    nomCompetence: nomCompetence,
  };

  if (type === 'validerCompetence') {
    $.getJSON('api/competences.php', {
      type: 'validation',
      idCompetence: idCompetence,
    });
    genererBoutonGestion(competenceObject, 'invaliderCompetenceTemporaire', 'Invalider la compétence', 'glyphicon-hourglass');
    //button.outerHTML = genererBouttonCompetence(idCompetence, nomCompetence, 'jaune', 'invaliderCompetenceTemporaire', 'glyphicon-hourglass');

  } else {
    $.getJSON('api/competences.php', {
      type: 'invalidation',
      idCompetence: idCompetence,
    });
    button.outerHTML = genererBouttonCompetence(idCompetence, nomCompetence, 'blanc', 'validerCompetence', 'glyphicon-remove');
  }
}

var lienPrecedent = null;

function afficherCompetence(lien, id) {
  'use strict';

  if (lienPrecedent !== null) {
    lienPrecedent.style.color = 'rgb(34, 68, 238)';
  }
  lienPrecedent = lien;
  lienPrecedent.style.color = 'rgb(232, 85, 36)';

  $.getJSON('api/competences.php', {
      type: 'sousCompetences',
      idPere: id,
    },
    function(competences) {
      $('#panel-body-competences').empty();
      $('#panel-body-competences').append(
        '<div class="list-group-item heading">' +
        lien.innerHTML +
        '</div>' +
        '<div id="competences-a-valider" class="list-group">' +
        '</div>');

      for (var competence of competences) {
        if (competence.valide) {
          if (competence.idTuteur == null) {
            $('#competences-a-valider').append(
              genererListGroupItem(competence, 'jaune', 'invaliderCompetenceTemporaire', 'glyphicon-hourglass')
            );
          } else {
            $('#competences-a-valider').append(
              genererListGroupItem(competence, 'vert', 'invaliderCompetence', 'glyphicon-ok')
            );
          }
        } else {
          $('#competences-a-valider').append(
            genererListGroupItem(competence, 'blanc', 'validerCompetence', 'glyphicon-remove')
          );
        }
      }
    }
  ).fail(
    function(competences, textStatus, error) {
      console.error('getJSON failed, status: ' + textStatus + ', error: ' + error);
    });
}

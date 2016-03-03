function genererListGroupItem(competence, couleurbg, type, classGlyphicon) {
  'use strict';

  var html = '';

  html = '<div id="list-group-item-' + competence.idCompetence + '"' +
    ' class="list-group-item cursor-pointer couleur-' + couleurbg +
    '-bg" data-toggle="modal" data-target="#genericModal" data-type="' + type +
    '" data-id-competence="' + competence.idCompetence + '" data-nom-competence="' + competence.nomCompetence + '">' +
    '<div class="media">' +
    '<div class="media-body">' +
    competence.nomCompetence +
    '</div>' +
    '<div class="media-right media-middle">' +
    '<span class="glyphicon ' + classGlyphicon + '" aria-hidden="true">' +
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

  var $listGroupItemCompetence = $('#list-group-item-' + idCompetence);

  if (type === 'validerCompetence') {
    $.getJSON('api/competences.php', {
      type: 'validation',
      idCompetence: idCompetence,
    });
    $listGroupItemCompetence.attr('data-type', 'invaliderCompetenceTemporaire');
  } else {
    $.getJSON('api/competences.php', {
      type: 'invalidation',
      idCompetence: idCompetence,
    });
    $listGroupItemCompetence.attr('data-type', 'validerCompetence');
  }

  $listGroupItemCompetence.toggleClass('couleur-jaune-bg');
  $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-remove');
  $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-hourglass');
}

var $lienPrecedent = null;

function afficherCompetence(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
  var nomCompetence = event.data.nomCompetence;

  if ($lienPrecedent !== null) {
    $lienPrecedent.toggleClass('text-selected');
    $lienPrecedent.toggleClass('text-default');
  }
  $lienPrecedent = $('#competence-' + idCompetence);
  $lienPrecedent.toggleClass('text-default');
  $lienPrecedent.toggleClass('text-selected');

  $.getJSON('api/competences.php', {
      type: 'sousCompetences',
      idPere: idCompetence,
    },
    function(competences) {
      $('#panel-body-competences').empty();
      $('#panel-body-competences').append(
        '<div class="list-group-item heading">' + nomCompetence +
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

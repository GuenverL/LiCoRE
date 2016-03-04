function genererListGroupItem(objet, couleurbg, type, classGlyphicon) {
  'use strict';

  var html = '';
  var id;
  var nom;

  if ((type === 'validationCompetencesUtilisateurs') || (type === 'invalidationCompetencesUtilisateurs')) {
    id = objet.idUtilisateur;
    nom = objet.prenomUtilisateur + ' ' + objet.nomUtilisateur;
  } else {
    id = objet.idCompetence;
    nom = objet.nomCompetence;
  }

  html = '<div id="list-group-item-' + id + '"' +
    ' class="list-group-item cursor-pointer couleur-' + couleurbg +
    '-bg" data-toggle="modal" data-target="#genericModal" data-type="' + type +
    '" data-id-competence="' + objet.idCompetence + '" data-nom-competence="' + objet.nomCompetence;

  if (type === 'validationCompetencesUtilisateurs') {
    html += '" data-nom-utilisateur="' + nom +
      '" data-id-utilisateur="' + id;
  }

  html += '"><div class="media">' +
    '<div class="media-body">' +
    nom +
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
  var idUtilisateur;

  if ((type === 'validationCompetencesUtilisateurs') || (type === 'invalidationCompetencesUtilisateurs')) {
    idUtilisateur = event.data.idUtilisateur;
  }

  var $listGroupItemCompetence = $('#list-group-item-' + idCompetence);

  if (type === 'validerCompetence') {
    $.getJSON('api/competences.php', {
      type: 'validation',
      idCompetence: idCompetence,
    });
    $listGroupItemCompetence.attr('data-type', 'invaliderCompetenceTemporaire');
  } else if (type === 'invaliderCompetence') {
    $.getJSON('api/competences.php', {
      type: 'invalidation',
      idCompetence: idCompetence,
    });
    $listGroupItemCompetence.attr('data-type', 'validerCompetence');
  } else if (type === 'validationCompetencesUtilisateurs') {
    $.getJSON('api/competences.php', {
      type: 'validationCompetencesUtilisateurs',
      idCompetence: idCompetence,
      idUtilisateur: idUtilisateur,
    });
    $listGroupItemCompetence.attr('data-type', 'invalidationCompetencesUtilisateurs');
  } else if (type === 'invalidationCompetencesUtilisateurs') {
    $.getJSON('api/competences.php', {
      type: 'invalidationCompetencesUtilisateurs',
      idCompetence: idCompetence,
      idUtilisateur: idUtilisateur,
    });
    $listGroupItemCompetence.attr('data-type', 'validationCompetencesUtilisateurs');
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
  var type = event.data.type;

  if ($lienPrecedent !== null) {
    $lienPrecedent.toggleClass('text-selected');
    $lienPrecedent.toggleClass('text-default');
  }
  $lienPrecedent = $('#competence-' + idCompetence);
  $lienPrecedent.toggleClass('text-default');
  $lienPrecedent.toggleClass('text-selected');

  if (type === 'sousCompetences') {
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
  } else {
    $.getJSON('api/competences.php', {
        type: 'getUtilisateursCompetence',
        idCompetence: idCompetence,
      },
      function(utilisateurs) {
        $('#panel-body-etudiants').empty();
        $('#panel-body-etudiants').append(
          '<div class="list-group-item heading">' + nomCompetence +
          '</div>' +
          '<div id="utilisateurs-a-valider" class="list-group">' +
          '</div>');

        for (var utilisateur of utilisateurs) {
          var params = {
            idCompetence: idCompetence,
            nomCompetence: nomCompetence,
            idUtilisateur: utilisateur.idUtilisateur,
            prenomUtilisateur: utilisateur.prenom,
            nomUtilisateur: utilisateur.nom,
          };
          $('#utilisateurs-a-valider').append(
            genererListGroupItem(params, 'blanc', 'validationCompetencesUtilisateurs', 'glyphicon-hourglass')
          );
        }
      }
    ).fail(
      function(utilisateurs, textStatus, error) {
        console.error('getJSON failed, status: ' + textStatus + ', error: ' + error);
      });
  }
}

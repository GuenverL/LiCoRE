$('#validationUtilisateursModal').on('shown.bs.modal', function(event) {
  'use strict';
  var $buttonAccepter = $('#buttonAccepter');
  var $buttonRefuser = $('#buttonRefuser');

  $(this).removeData('modal');

  $buttonAccepter.off();
  $buttonRefuser.off();

  var $button = $(event.relatedTarget);
  var idCompetence = $button[0].dataset.idCompetence;
  var nomCompetence = $button[0].dataset.nomCompetence;
  var idUtilisateur = $button[0].dataset.idUtilisateur;
  var nomUtilisateur = $button[0].dataset.nomUtilisateur;
  var explicationsUtilisateur;

  $.getJSON('api/competences.php', {
      type: 'getExplications',
      idCompetence: idCompetence,
      idUtilisateur: idUtilisateur,
    },
    function(explications) {
      explicationsUtilisateur = explications;
    });

  var $modal = $(this);

  var body;

  if (explicationsUtilisateur) {
    body += '<div class="alert alert-info" role="alert">...</div>';
  }
  body += '<div class="form-group">' +
    '<label for="explications-validation" class="control-label" id="label"></label>' +
    '<textarea rows="10" class="form-control" id="explicationsValidation"></textarea>' +
    '</div>';

  $modal.find('.modal-body #validationUtilisateursModalForm').empty();
  $modal.find('.modal-title').text('Valider la compétence "' + nomCompetence + '" pour "' + nomUtilisateur + '"');
  $modal.find('.modal-body #validationUtilisateursModalForm').append(body);
  $modal.find('.modal-body #label').text('En cas de refus, expliquez la raison pour que l\'étudiant puisse savoir ce qu\'il doit améliorer :');

  var objetAccepter = {
    idCompetence: idCompetence,
    nomCompetence: nomCompetence,
    idUtilisateur: idUtilisateur,
    type: 'accepterValidation',
  };
  $buttonAccepter.click(objetAccepter, buttonSubmitValidation);
  var objetRefuser = {
    idCompetence: idCompetence,
    nomCompetence: nomCompetence,
    idUtilisateur: idUtilisateur,
    type: 'refuserValidation',
  };
  $buttonRefuser.click(objetRefuser, buttonSubmitValidation);
});

function genererListGroupItem(objet, couleurbg, type, title, classGlyphicon, estConnecte) {
  'use strict';

  var html = '';
  var id;
  var nom;

  if ((type === 'validationCompetenceParTuteur') || (type === 'invalidationCompetencesUtilisateurs')) {
    id = objet.idUtilisateur;
    nom = objet.prenomUtilisateur + ' ' + objet.nomUtilisateur;
  } else {
    id = objet.idCompetence;
    nom = objet.nomCompetence;
  }

  html = '<div id="list-group-item-' + id + '"' +
    ' class="list-group-item cursor-pointer couleur-' + couleurbg +
    '-bg" data-toggle="modal" ';

  if (estConnecte) {
    if (type === 'validationCompetenceParTuteur') {
      html += 'data-target="#validationUtilisateursModal"';
    } else {
      html += 'data-target="#genericModal"';
    }
    html += ' data-type="' + type +
      '" data-id-competence="' + objet.idCompetence + '" data-nom-competence="' + objet.nomCompetence;
  } else {
    html += 'data-target="#connexionModal"';
  }

  if (type === 'validationCompetenceParTuteur') {
    html += '" data-nom-utilisateur="' + nom +
      '" data-id-utilisateur="' + id;
  }

  html += '"><div class="media">' +
    '<div class="media-body">' +
    nom;

  if (couleurbg === 'valide') {
    html += '<hr class="separation-competence-valide">' +
      'Validée par ' + objet.prenomTuteur + ' ' + objet.nomTuteur + ' le ' + objet.dateValidation;
  }

  html += '</div><div class="media-right media-middle">';

  if ((type === 'validationCompetenceParTuteur') || (type === 'invalidationCompetencesUtilisateurs')) {
    html += ' <span id="utilisateur-';
  } else {
    html += ' <span id="competence-';
  }

  html += id + '" data-toggle="modal"' +
    ' data-placement="top"' +
    ' data-original-title="' + title +
    '" class="glyphicon cursor-pointer ' + classGlyphicon +
    '" aria-hidden="true"></span></div></div>';

  return html;
}

function buttonSubmitValidation(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
  var nomCompetence = event.data.nomCompetence;
  var type = event.data.type;
  var idUtilisateur;
  var $listGroupItemCompetence;

  if ((type === 'accepterValidation') || (type === 'refuserValidation')) {
    idUtilisateur = event.data.idUtilisateur;
    $listGroupItemCompetence = $('#list-group-item-' + idUtilisateur);
  } else {
    $listGroupItemCompetence = $('#list-group-item-' + idCompetence);
  }

  $('.tooltip').remove();

  var clearData = function() {
    $listGroupItemCompetence.removeAttr('data-target');
    $listGroupItemCompetence.removeAttr('data-toggle');
    $listGroupItemCompetence.removeAttr('data-original-title');
    $listGroupItemCompetence.removeAttr('data-id-utilisateur');
    $listGroupItemCompetence.removeAttr('data-nom-utilisateur');
    $listGroupItemCompetence.removeAttr('data-id-competence');
    $listGroupItemCompetence.removeAttr('data-nom-competence');
    $listGroupItemCompetence.removeAttr('data-type');
    $listGroupItemCompetence.removeAttr('title');
    $listGroupItemCompetence.find('span.glyphicon').first().remove();
  }

  if (type === 'validerCompetence') {
    $.getJSON('api/competences.php', {
      type: 'validation',
      idCompetence: idCompetence,
      explications: $('#genericModal').find('.modal-body #explicationsValidation').val(),
    });
    $listGroupItemCompetence.attr('data-type', 'invaliderCompetenceTemporaire');
    $listGroupItemCompetence.toggleClass('couleur-attente-bg');
    $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-ok');
    $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-hourglass');
    $listGroupItemCompetence.find('span.glyphicon-hourglass').first().attr('data-original-title', 'Compétence en attente de validation');
  } else if (type === 'invaliderCompetenceTemporaire') {
    $.getJSON('api/competences.php', {
      type: 'invalidation',
      idCompetence: idCompetence,
    });
    $listGroupItemCompetence.attr('data-type', 'validerCompetence');
    $listGroupItemCompetence.toggleClass('couleur-attente-bg');
    $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-ok');
    $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-hourglass');
    $listGroupItemCompetence.find('span.glyphicon-ok').first().attr('data-original-title', 'Valider la compétence');
  } else if (type === 'invaliderCompetence') {
    $.getJSON('api/competences.php', {
      type: 'invalidation',
      idCompetence: idCompetence,
    });
    $listGroupItemCompetence.attr('data-type', 'validerCompetence');
    $listGroupItemCompetence.toggleClass('couleur-valide-bg');
    $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-ok');
    $listGroupItemCompetence.find('span.glyphicon').first().toggleClass('glyphicon-remove');
    $listGroupItemCompetence.find('span.glyphicon-ok').first().attr('data-original-title', 'Valider la compétence');
  } else if (type === 'accepterValidation') {
    $.getJSON('api/competences.php', {
      type: 'accepterValidation',
      idCompetence: idCompetence,
      idUtilisateur: idUtilisateur,
    });
    clearData();
    $listGroupItemCompetence.toggleClass('couleur-attente-bg');
    $listGroupItemCompetence.toggleClass('couleur-valide-bg');
  } else if (type === 'refuserValidation') {
    $.getJSON('api/competences.php', {
      type: 'refuserValidation',
      idCompetence: idCompetence,
      idUtilisateur: idUtilisateur,
      explications: $('#genericModal').find('.modal-body #validationUtilisateursModal').val(),
    });
    clearData();
    $listGroupItemCompetence.toggleClass('couleur-attente-bg');
    $listGroupItemCompetence.toggleClass('couleur-invalide-bg');
    $listGroupItemCompetence.toggleClass('couleur-text-invalide');
  }
}

var $lienPrecedent = null;

function afficherCompetence(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
  var nomCompetence = event.data.nomCompetence;
  var type = event.data.type;
  var estConnecte;

  if ($lienPrecedent !== null) {
    $lienPrecedent.toggleClass('couleur-text-selection');
    $lienPrecedent.toggleClass('couleur-text-lien');
  }
  $lienPrecedent = $('#competence-' + idCompetence);
  $lienPrecedent.toggleClass('couleur-text-lien');
  $lienPrecedent.toggleClass('couleur-text-selection');

  $.getJSON('api/competences.php', {
      type: 'estConnecte',
    },
    function(connexion) {
      estConnecte = connexion.estConnecte;
    });

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

        for (var i = 0, len = competences.length; i < len; ++i) {
          var competence = competences[i];
          if (competence.etat === 'attente') {
            $('#competences-a-valider').append(
              genererListGroupItem(competence, 'attente', 'invaliderCompetenceTemporaire', 'Compétence en attente de validation', 'glyphicon-hourglass', estConnecte)
            );
          } else if (competence.etat === 'valide') {
            $('#competences-a-valider').append(
              genererListGroupItem(competence, 'valide', 'invaliderCompetence', 'Invalider la compétence', 'glyphicon-remove', estConnecte)
            );
          } else {
            $('#competences-a-valider').append(
              genererListGroupItem(competence, '', 'validerCompetence', 'Valider la compétence', 'glyphicon-ok', estConnecte)
            );
          }
        }
        $('[data-toggle="modal"]').tooltip();
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

        for (var i = 0, len = utilisateurs.length; i < len; ++i) {
          var utilisateur = utilisateurs[i];
          var params = {
            idCompetence: idCompetence,
            nomCompetence: nomCompetence,
            idUtilisateur: utilisateur.idUtilisateur,
            prenomUtilisateur: utilisateur.prenom,
            nomUtilisateur: utilisateur.nom,
          };
          $('#utilisateurs-a-valider').append(
            genererListGroupItem(params, 'attente', 'validationCompetenceParTuteur', 'Valider l\'étudiant', 'glyphicon-hourglass', true)
          );
        }
        $('[data-toggle="modal"]').tooltip();
      }
    ).fail(
      function(utilisateurs, textStatus, error) {
        console.error('getJSON failed, status: ' + textStatus + ', error: ' + error);
      });
  }
}

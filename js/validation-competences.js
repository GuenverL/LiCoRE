function validation(id, button, type) {
  span = document.getElementById("idComp" + id)

  switch (type) {
    case 'validerCompetence':
      $.getJSON('api/competences.php', {
        type: 'validation',
        idCompetence: id
      });
      button.className += " couleur-jaune-bg";
      span.className = "glyphicon glyphicon-hourglass";

      break;

    case 'invaliderCompetence':
      $.getJSON('api/competences.php', {
        type: 'invalidation',
        idCompetence: id
      });

      button.className = "list-group-item cursor-pointer";
      span.className = "glyphicon glyphicon-remove";

      break;

    default:
      break;
  }
}

var lienPrecedent = null;

function afficherCompetence(lien, id) {

  if (lienPrecedent !== null) {
    lienPrecedent.style.color = 'rgb(34, 68, 238)';
  }
  lienPrecedent = lien;
  lienPrecedent.style.color = 'rgb(232, 85, 36)';

  $.getJSON(
    'api/competences.php', {
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
        if (competence.valide == true) {
          if (competence.idTuteur == null) {
            $('#competences-a-valider').append(
              '<div class="list-group-item cursor-pointer couleur-jaune-bg" data-toggle="modal" data-target="#validationCompetencesModal" data-type="invaliderCompetence" data-id-competence="' + competence.id + '" data-nom-competence="' + competence.nom + '">' +
              '<div class="media">' +
              '<div class="media-body">' +
              competence.nom +
              '</div>' +
              '<div class="media-right media-middle">' +
              '<span id="idComp' + competence.id + '" class="glyphicon glyphicon-hourglass" aria-hidden="true">' +
              '</span>' +
              '</div>' +
              '</div>' +
              '</div>');
          } else {
            $('#competences-a-valider').append(
              '<div class="list-group-item cursor-pointer couleur-verte-bg" data-toggle="modal" data-target="#validationCompetencesModal" data-type="invaliderCompetence" data-id-competence="' + competence.id + '" data-nom-competence="' + competence.nom + '">' +
              '<div class="media">' +
              '<div class="media-body">' +
              competence.nom +
              '</div>' +
              '<div class="media-right media-middle">' +
              '<span id="idComp' + competence.id + '" class="glyphicon glyphicon-ok" aria-hidden="true">' +
              '</span>' +
              '</div>' +
              '</div>' +
              '</div>');
          }
        } else {
          $('#competences-a-valider').append(
            '<div class="list-group-item cursor-pointer" data-toggle="modal" data-target="#validationCompetencesModal" data-type="validerCompetence" data-id-competence="' + competence.id + '" data-nom-competence="' + competence.nom + '">' +
            '<div class="media">' +
            '<div class="media-body">' +
            competence.nom +
            '</div>' +
            '<div class="media-right media-middle">' +
            '<span id="idComp' + competence.id + '" class="glyphicon glyphicon-remove" aria-hidden="true">' +
            '</span>' +
            '</div>' +
            '</div>' +
            '</div>');
        }
      }
    }
  ).fail(
    function(competences, textStatus, error) {
      console.error('getJSON failed, status: ' + textStatus + ', error: ' + error);
    }
  );
}

$('#validationCompetencesModal').on('show.bs.modal', function(event) {
  'use strict';
  var $buttonSubmit = $('#buttonSubmit');

  $(this).removeData();
  $buttonSubmit.off();

  var $button = $(event.relatedTarget);
  var idCompetence = $button.data('id-competence');
  var nomCompetence = $button.data('nom-competence');
  var type = $button.data('type');
  var $modal = $(this);

  var updateModal = function(params) {
    $modal.find('.modal-body #validationCompetencesModalForm').empty();
    $modal.find('.modal-title').text(params.title);
    $modal.find('.modal-body #validationCompetencesModalForm').append(params.body);
    $modal.find('.modal-body #label').text(params.label);
    $modal.find('.modal-body #nomCompetence').val(params.nomCompetence);
  };

  var paramsModal = {};

  if (type === 'validerCompetence') {
    paramsModal.label = '';
    paramsModal.nomCompetence = nomCompetence;
    paramsModal.title = 'Validation de la compétence "' + nomCompetence + '"';
    paramsModal.body = '<div class="alert alert-warning" role="alert">' +
      '<strong>Attention!</strong>' +
      '<p>Vous allez valider une compétence et celle ci sera donc mise en attente de validation par un tuteur. Voulez vous continuer ?</p></div>';
  } else if (type === 'invaliderCompetence') {
    paramsModal.label = '';
    paramsModal.nomCompetence = nomCompetence;
    paramsModal.title = 'Invalidation de la compétence "' + nomCompetence + '"';
    paramsModal.body = '<div class="alert alert-warning" role="alert">' +
      '<strong>Attention!</strong>' +
      '<p>Vous allez invalider une compétence et celle ci sera donc retiré de votre liste de compétences validées. Voulez vous continuer ?</p></div>';
  }

  updateModal(paramsModal);

  $buttonSubmit.on('click', function() {
    validation(idCompetence, $button[0], type);
  });
});

$('#toggleFullscreenCompetencesValidees').click(function() {
  if ($('#col-competences-validees').hasClass('col-md-4')) {
    $('#col-liste-competences').css({
      display: "none"
    });
    $('#col-competences-a-valider').css({
      display: "none"
    });
  } else {
    $('#col-liste-competences').css({
      display: "block"
    });
    $('#col-competences-a-valider').css({
      display: "block"
    });
  }

  $('#col-competences-validees').toggleClass('col-md-4');
  $('#col-competences-validees').toggleClass('col-md-12');
});

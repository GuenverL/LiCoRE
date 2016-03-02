var $buttonSelectionne = $('#buttonToutesCompetences');
var typeAffichageCompetences = 'getToutesLesCompetences';

function setCompetencesVisibilite(competences, visibilite) {
  'use strict';

  for (var competence of competences) {
    if (visibilite === 'setCompetencesInvisibles') {
      $('#competence-' + competence.idCompetence).addClass('couleur-grise');
      $('#competence-' + competence.idCompetence).find('span.glyphicon-eye-close').remove();
      $('#competence-' + competence.idCompetence).find('span.glyphicon-eye-open').remove();
      $('#competence-' + competence.idCompetence).find('span.glyphicon-pencil').after(
        genererBoutonGestion(competence, 'setCompetencesVisibles', 'Rendre la compétence visible', 'glyphicon-eye-open couleur-bleue'));
    } else {
      $('#competence-' + competence.idCompetence).toggleClass('couleur-grise');
      $('#competence-' + competence.idCompetence).find('span.glyphicon-eye-open').first().remove();
      $('#competence-' + competence.idCompetence).find('span.glyphicon-pencil').first().after(
        genererBoutonGestion(competence, 'setCompetencesInvisibles', 'Rendre la compétence invisible', 'glyphicon-eye-close couleur-bleue'));
    }
  }
}

function setCompetencesVisibiliteOnClick(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
  var nomCompetence = event.data.nomCompetence;
  var visibilite = event.data.visibilite;

  $.getJSON('api/competences.php', {
    type: visibilite,
    idCompetence: idCompetence,
  }).always(function(competences) {
    $('.tooltip').remove();
    setCompetencesVisibilite(competences, visibilite);
    $('[data-toggle="modal"]').tooltip();
  });
}

$('#gestionCompetencesModal').on('show.bs.modal', function(event) {
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
    $modal.find('.modal-body #gestionCompetencesModalForm').empty();
    $modal.find('.modal-title').text(params.title);
    $modal.find('.modal-body #gestionCompetencesModalForm').append(params.body);
    $modal.find('.modal-body #label').text(params.label);
    $modal.find('.modal-body #nomCompetence').val(params.nomCompetence);
  };

  var paramsModal = {};

  switch (type) {
    case 'ajouterCompetence':
      paramsModal.title = 'Ajouter une compétence à "' + nomCompetence + '"';
      paramsModal.body = '<div class="form-group">' +
        '<label for="nom-competence" class="control-label" id="label"></label>' +
        '<input type="text" class="form-control" id="nomCompetence">' +
        '</div>';
      paramsModal.label = 'Nom de la nouvelle compétence :';
      paramsModal.nomCompetence = '';
      break;

    case 'ajouterPlusieursCompetences':
      paramsModal.title = 'Ajouter des compétences à "' + nomCompetence + '"';
      paramsModal.body = '<div class="form-group">' +
        '<label for="nom-competence" class="control-label" id="label"></label>' +
        '<textarea rows="20" class="form-control" id="nomCompetence"></textarea>' +
        '</div>';
      paramsModal.label = 'Nom des nouvelles compétences (séparée par un retour à la ligne) :';
      paramsModal.nomCompetence = '';
      break;

    case 'modifierCompetence':
      paramsModal.title = 'Modifier la compétence "' + nomCompetence + '"';
      paramsModal.body = '<div class="form-group">' +
        '<label for="nom-competence" class="control-label" id="label"></label>' +
        '<input type="text" class="form-control" id="nomCompetence">' +
        '</div>';
      paramsModal.label = 'Nom :';
      paramsModal.nomCompetence = nomCompetence;
      break;

    case 'supprimerCompetence':
      var feuille = $button.data('feuille');
      paramsModal.label = '';
      paramsModal.nomCompetence = nomCompetence;

      if (feuille) {
        paramsModal.title = 'Supprimer la compétence "' + nomCompetence + '"';
        paramsModal.body = '<div class="alert alert-danger" role="alert">' +
          '<strong>Attention!</strong>' +
          '<p>Voulez-vous vraiment continuer et supprimer cette compétence ?</p></div>';

      } else {
        paramsModal.title = 'Supprimer la catégorie "' + nomCompetence + '" et ses sous-compétences';
        paramsModal.body = '<div class="alert alert-danger" role="alert">' +
          '<strong>Attention!</strong>' +
          '<p>La suppression de cette catégorie entrainera la suppression ' +
          'de toutes ses sous-catégories et compétences.</p>' +
          '<p>Voulez-vous vraiment continuer et supprimer cette catégorie ?</p></div>';
      }
      break;

    case 'setCompetencesInvisibles':
      paramsModal.label = '';
      paramsModal.nomCompetence = nomCompetence;
      paramsModal.title = 'Rendre invisible la catégorie "' + nomCompetence + '" et ses sous-compétences';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>Attention!</strong>' +
        '<p>Rendre invisible cette catégorie va mettre invisible ' +
        'toutes ses sous-catégories et compétences.</p>' +
        '<p>Voulez-vous vraiment continuer et rendre invisible cette catégorie ?</p></div>';
      break;
  }

  updateModal(paramsModal);

  $buttonSubmit.on('click', function() {
    var nouveauNomCompetence = $modal.find('.modal-body #nomCompetence').val();
    $.getJSON('api/competences.php', {
      type: type,
      idCompetence: idCompetence,
      nomCompetence: nouveauNomCompetence,
    }).always(function(competences) {
      if (competences) {
        switch (type) {
          case 'ajouterCompetence':
            if (competences.idCompetence !== -1) {
              var longueur = $('#competence-' + idCompetence).find('ul').length;
              var ouvert = $('#competence-' + idCompetence).find('i').hasClass('glyphicon-chevron-down');
              if (longueur === 0) {
                $('#competence-' + idCompetence).append('<ul>');
              }

              if (ouvert) {
                $('#competence-' + idCompetence).find('ul').first().append(
                  genererLigneCompetenceGestion(competences, 'display-normal'));
              } else {
                $('#competence-' + idCompetence).find('ul').first().append(
                  genererLigneCompetenceGestion(competences, 'display-none'));
              }

              if (longueur === 0) {
                $('#competence-' + idCompetence).append('</ul>');
                actualiserBranche($('#competence-' + idCompetence));
                $('#competence-' + idCompetence).find('i').removeClass('glyphicon-chevron-right');
                $('#competence-' + idCompetence).find('i').addClass('glyphicon-chevron-down');
              }
            }
            break;

          case 'ajouterPlusieursCompetences':
            longueur = $('#competence-' + idCompetence).find('ul').length;
            ouvert = $('#competence-' + idCompetence).find('i').hasClass('glyphicon-chevron-down');
            if (longueur === 0) {
              $('#competence-' + idCompetence).append('<ul>');
            }
            for (var competence of competences) {
              if (competence.idCompetence !== -1) {
                if (ouvert) {
                  $('#competence-' + idCompetence).find('ul').first().append(
                    genererLigneCompetenceGestion(competence, 'display-normal'));
                } else {
                  $('#competence-' + idCompetence).find('ul').first().append(
                    genererLigneCompetenceGestion(competence, 'display-none'));
                }
              }
            }
            if (longueur === 0) {
              $('#competence-' + idCompetence).append('</ul>');
              actualiserBranche($('#competence-' + idCompetence));
              $('#competence-' + idCompetence).find('i').removeClass('glyphicon-chevron-right');
              $('#competence-' + idCompetence).find('i').addClass('glyphicon-chevron-down');
            }
            break;

          case 'modifierCompetence':
            if (competences.retour) {
              $('#competence-' + idCompetence).find('span.glyphicon-plus').first().attr('data-nom-competence', nouveauNomCompetence);
              $('#competence-' + idCompetence).find('span.glyphicon-th-list').first().attr('data-nom-competence', nouveauNomCompetence);
              $('#competence-' + idCompetence).find('span.glyphicon-pencil').first().attr('data-nom-competence', nouveauNomCompetence);
              $('#competence-' + idCompetence).find('span.glyphicon-eye-close').first().attr('data-nom-competence', nouveauNomCompetence);
              $('#competence-' + idCompetence).find('span.glyphicon-eye-open').first().attr('data-nom-competence', nouveauNomCompetence);
              $('#competence-' + idCompetence).find('span.glyphicon-remove').first().attr('data-nom-competence', nouveauNomCompetence);
              $('#competence-' + idCompetence).find('a').first().empty();
              $('#competence-' + idCompetence).find('a').first().append(nouveauNomCompetence);
            }
            break;

          case 'setCompetencesInvisibles':
            setCompetencesVisibilite(competences, 'setCompetencesInvisibles');
            break;

          case 'supprimerCompetence':
            $('#competence-' + idCompetence).remove();
            break;

          default:
            $.getJSON('api/competences.php', {
              type: typeAffichageCompetences,
            }).always(function(competences) {
              $('#arbreGestionCompetences').empty();
              $('#arbreGestionCompetences').append('<li id="listeCompetences"><a href="#">Liste des compétences</a>');
              $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'gestionCompetences'));
              majArbre('#arbreGestionCompetences');
              $('[data-toggle="modal"]').tooltip();
            });
        }
      }
    });
  });
});

function majButtons(nouveauBouton) {
  'use strict';

  $buttonSelectionne.removeClass('active');
  nouveauBouton.addClass('active');
  $buttonSelectionne = nouveauBouton;
}

function majArbreGestionCompetences(button, type) {
  'use strict';

  var $button = $(button);
  typeAffichageCompetences = type;
  if ($buttonSelectionne.selector !== $button.selector) {
    majButtons($button);
    $('#arbreGestionCompetences').empty();
    $.getJSON('api/competences.php', {
      type: type,
    }).always(function(competences) {
      if (competences.responseText !== '') {
        $('#arbreGestionCompetences').append('<li id="listeCompetences"><a href="#">Liste des compétences</a>');
        $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'gestionCompetences'));
        majArbre('#arbreGestionCompetences');
        $('[data-toggle="modal"]').tooltip();
      }
    });
  }
}

$('#buttonToutesCompetences').on('click', function() {
  'use strict';
  majArbreGestionCompetences('#buttonToutesCompetences', 'getToutesLesCompetences');
});

$('#buttonCompetencesVisibles').on('click', function() {
  'use strict';
  majArbreGestionCompetences('#buttonCompetencesVisibles', 'getCompetencesVisibles');
});

$('#buttonCompetencesInvisibles').on('click', function() {
  'use strict';
  majArbreGestionCompetences('#buttonCompetencesInvisibles', 'getCompetencesInvisibles');
});

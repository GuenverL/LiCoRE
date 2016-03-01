var $buttonSelectionne = $('#buttonToutesCompetences');
var typeAffichageCompetences = 'getToutesLesCompetences';

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

  if (type === 'ajouterCompetence') {
    paramsModal.title = 'Ajouter une compétence à "' + nomCompetence + '"';
    paramsModal.body = '<div class="form-group">' +
      '<label for="nom-competence" class="control-label" id="label"></label>' +
      '<input type="text" class="form-control" id="nomCompetence">' +
      '</div>';
    paramsModal.label = 'Nom de la nouvelle compétence :';
    paramsModal.nomCompetence = '';

  } else if (type === 'ajouterPlusieursCompetences') {
    paramsModal.title = 'Ajouter des compétences à "' + nomCompetence + '"';
    paramsModal.body = '<div class="form-group">' +
      '<label for="nom-competence" class="control-label" id="label"></label>' +
      '<textarea rows="20" class="form-control" id="nomCompetence"></textarea>' +
      '</div>';
    paramsModal.label = 'Nom des nouvelles compétences (séparée par un retour à la ligne) :';
    paramsModal.nomCompetence = '';

  } else if (type === 'modifierCompetence') {
    paramsModal.title = 'Modifier la compétence "' + nomCompetence + '"';
    paramsModal.body = '<div class="form-group">' +
      '<label for="nom-competence" class="control-label" id="label"></label>' +
      '<input type="text" class="form-control" id="nomCompetence">' +
      '</div>';
    paramsModal.label = 'Nom :';
    paramsModal.nomCompetence = nomCompetence;

  } else if (type === 'supprimerCompetence') {
    var feuille = $button.data('feuille');
    paramsModal.label = '';
    paramsModal.nomCompetence = nomCompetence;

    if (feuille) {
      paramsModal.title = 'Supprimer la compétence "' + nomCompetence + '"';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>Attention!</strong>' +
        '<p>Voulez-vous vraiment continuer et supprimer cette compétence ?</p></div>';

    } else {
      paramsModal.title = 'Supprimer la catégorie "' + nomCompetence + '" et ses sous-compétences';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>Attention!</strong>' +
        '<p>La suppression de cette catégorie entrainera la suppression ' +
        'de toutes ses sous-catégories et compétences.</p>' +
        '<p>Voulez-vous vraiment continuer et supprimer cette catégorie ?</p></div>';
    }
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
            var longueur = $('#competence-' + idCompetence).find('ul').length;
            var ouvert = $('#competence-' + idCompetence).find('i').hasClass('glyphicon-chevron-down');
            if (longueur === 0) {
              $('#competence-' + idCompetence).append('<ul>');
            }

            if (ouvert) {
              $('#competence-' + idCompetence).find('ul').first().append(
                genererLigneCompetenceGestion(competences.idCompetence, competences.nomCompetence, 1, 'display-normal'));
            } else {
              $('#competence-' + idCompetence).find('ul').first().append(
                genererLigneCompetenceGestion(competences.idCompetence, competences.nomCompetence, 1, 'display-none'));
            }

            if (longueur === 0) {
              $('#competence-' + idCompetence).append('</ul>');
              actualiserBranche($('#competence-' + idCompetence));
              $('#competence-' + idCompetence).find('i').removeClass('glyphicon-chevron-right');
              $('#competence-' + idCompetence).find('i').addClass('glyphicon-chevron-down');
            }
            break;

          case 'ajouterPlusieursCompetences':
            longueur = $('#competence-' + idCompetence).find('ul').length;
            ouvert = $('#competence-' + idCompetence).find('i').hasClass('glyphicon-chevron-down');
            if (longueur === 0) {
              $('#competence-' + idCompetence).append('<ul>');
            }
            for (var competence of competences) {
              if (ouvert) {
                $('#competence-' + idCompetence).find('ul').first().append(
                  genererLigneCompetenceGestion(competence.idCompetence, competence.nomCompetence, 1, 'display-normal'));
              } else {
                $('#competence-' + idCompetence).find('ul').first().append(
                  genererLigneCompetenceGestion(competence.idCompetence, competence.nomCompetence, 1, 'display-none'));
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
              $('#competence-' + idCompetence).find('a').first().empty();
              $('#competence-' + idCompetence).find('a').first().append(nouveauNomCompetence);
            }
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

function setCompetencesVisibilite(visibilite, idCompetence, nomCompetence) {
  'use strict';

  // var visible = $('#competence-' + idCompetence).findExclude('span.glyphicon-eye-close', 'span.glyphicon-eye-remove');
  // Find-like method which masks any descendant
  // branches matching the Mask argument.
  $.fn.findExclude = function(selector, mask, result) {
    result = typeof result !== 'undefined' ? result : new jQuery();
    this.children().each(function() {
      var thisObject = jQuery(this);
      if (thisObject.is(selector))
        result.push(this);
      if (!thisObject.is(mask))
        thisObject.findExclude(selector, mask, result);
    });
    return result;
  };

  var actualiserGlyphicon = function(idCompetence, nomCompetence, visibilite) {
    if (visibilite === 'setCompetencesInvisibles') {
      $('#competence-' + idCompetence).addClass('couleur-grise');
      $('#competence-' + idCompetence).find('span.glyphicon-eye-close').remove();
      $('#competence-' + idCompetence).find('span.glyphicon-eye-open').remove();
      $('#competence-' + idCompetence).find('span.glyphicon-pencil').after(
        genererBoutonGestion(idCompetence, nomCompetence, 'setCompetencesVisibles', 'Rendre la compétence visible', 'glyphicon-eye-open couleur-bleue'));
    } else {
      $('#competence-' + idCompetence).toggleClass('couleur-grise');
      $('#competence-' + idCompetence).find('span.glyphicon-eye-open').first().remove();
      $('#competence-' + idCompetence).find('span.glyphicon-pencil').first().after(
        genererBoutonGestion(idCompetence, nomCompetence, 'setCompetencesInvisibles', 'Rendre la compétence invisible', 'glyphicon-eye-close couleur-bleue'));
    }
  };

  $.getJSON('api/competences.php', {
    type: visibilite,
    idCompetence: idCompetence,
  }).always(function(competences) {
    $('.tooltip').remove();

    for (var competence of competences) {
      actualiserGlyphicon(competence.idCompetence, competence.nomCompetence, visibilite);
    }

    $('[data-toggle="modal"]').tooltip();
  });
}

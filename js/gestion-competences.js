var $buttonSelectionne = $('#buttonToutesCompetences');
var typeAffichageCompetences = 'getToutesLesCompetences';

function setCompetencesVisibilite(competences, visibilite) {
  'use strict';

  for (var i = 0, len = competences.length; i < len; ++i) {
    var competence = competences[i];
    if (visibilite === 'setCompetencesInvisibles') {
      $('#competence-' + competence.idCompetence).toggleClass('couleur-grise');
      $('#competence-' + competence.idCompetence).find('span.glyphicon-eye-close').remove();
      $('#competence-' + competence.idCompetence).find('span.glyphicon-eye-open').remove();
      $('#competence-' + competence.idCompetence).find('span.glyphicon-pencil').after(
        genererBoutonGestion(competence, 'setCompetencesVisibles', 'Rendre la compétence visible', 'glyphicon-eye-open couleur-bleue'));

      var competenceObjet = {
        idCompetence: competence.idCompetence,
        nomCompetence: competence.nomCompetence,
        visibilite: 'setCompetencesVisibles',
      };
      $('#competence-' + competence.idCompetence + '-button-visibilite').off();
      $('#competence-' + competence.idCompetence + '-button-visibilite').click(competenceObjet, setCompetencesVisibiliteOnClick);
    } else {
      $('#competence-' + competence.idCompetence).toggleClass('couleur-grise');
      $('#competence-' + competence.idCompetence).find('span.glyphicon-eye-open').first().remove();
      $('#competence-' + competence.idCompetence).find('span.glyphicon-pencil').first().after(
        genererBoutonGestion(competence, 'setCompetencesInvisibles', 'Rendre la compétence invisible', 'glyphicon-eye-close couleur-bleue'));
      $('#competence-' + competence.idCompetence + '-button-visibilite').off();
    }
  }
}

function setCompetencesVisibiliteOnClick(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
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
    $('#arbreGestionCompetences').hide();
    $('#loader-competences').show();
    $.getJSON('api/competences.php', {
      type: type,
    }).always(function(competences) {
      if (competences.responseText !== '') {
        $('#arbreGestionCompetences').append('<li id="listeCompetences"><a href="#">Liste des compétences</a>');
        $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'gestionCompetences'));
        majArbre('#arbreGestionCompetences');
        $('[data-toggle="modal"]').tooltip();

        for (var i = 0, len = competences.length; i < len; ++i) {
          var competence = competences[i];
          if (competence.feuille) {
            var visibilite;
            if (competence.visible || competence.visible === undefined) {
              visibilite = 'setCompetencesInvisibles';
            } else {
              visibilite = 'setCompetencesVisibles';
            }
            var competenceObjet = {
              idCompetence: competence.idCompetence,
              nomCompetence: competence.nomCompetence,
              visibilite: visibilite,
            };
            $('#competence-' + competence.idCompetence + '-button-visibilite').click(competenceObjet, setCompetencesVisibiliteOnClick);
          }
        }

        $('#loader-competences').hide();
        $('#arbreGestionCompetences').show();
      }
    });
  }
}

$('#buttonToutesCompetences').click(function() {
  'use strict';
  majArbreGestionCompetences('#buttonToutesCompetences', 'getToutesLesCompetences');
});

$('#buttonCompetencesVisibles').click(function() {
  'use strict';
  majArbreGestionCompetences('#buttonCompetencesVisibles', 'getCompetencesVisibles');
});

$('#buttonCompetencesInvisibles').click(function() {
  'use strict';
  majArbreGestionCompetences('#buttonCompetencesInvisibles', 'getCompetencesInvisibles');
});

function buttonSubmitGestionCompetences(event) {
  'use strict';

  var idCompetence = event.data.idCompetence;
  var type = event.data.type;

  var nouveauNomCompetence = $('#genericModal').find('.modal-body #nomCompetence').val();
  $.getJSON('api/competences.php', {
    type: type,
    idCompetence: idCompetence,
    nomCompetence: nouveauNomCompetence,
  }).always(function(competences) {
    if (competences) {

      var genererLigneAjoutCompetences = function(competences) {
        var longueur = $('#competence-' + idCompetence).find('ul').length;
        var ouvert = $('#competence-' + idCompetence).find('i').hasClass('glyphicon-chevron-down');
        if (longueur === 0) {
          $('#competence-' + idCompetence).append('<ul>');
        }

        for (var i = 0, len = competences.length; i < len; ++i) {
          var competence = competences[i];
          if (competence.idCompetence !== -1) {
            if (ouvert) {
              $('#competence-' + idCompetence).find('ul').first().append(
                genererLigneCompetenceGestion(competence, 'display-normal'));
            } else {
              $('#competence-' + idCompetence).find('ul').first().append(
                genererLigneCompetenceGestion(competence, 'display-none'));
            }

            var visibilite;
            if (competence.visible) {
              visibilite = 'setCompetencesInvisibles';
            } else {
              visibilite = 'setCompetencesVisibles';
            }

            var competenceObjet = {
              idCompetence: competence.idCompetence,
              nomCompetence: competence.nomCompetence,
              visibilite: visibilite,
            };
            $('#competence-' + competence.idCompetence + '-button-visibilite').off();
            $('#competence-' + competence.idCompetence + '-button-visibilite').click(competenceObjet, setCompetencesVisibiliteOnClick);
          }
        }

        if (longueur === 0) {
          $('#competence-' + idCompetence).append('</ul>');
          actualiserBranche($('#competence-' + idCompetence));
          $('#competence-' + idCompetence).find('i').removeClass('glyphicon-chevron-right');
          $('#competence-' + idCompetence).find('i').addClass('glyphicon-chevron-down');
        }
      };

      switch (type) {
        case 'ajouterCompetence':
          if (competences.idCompetence !== -1) {
            genererLigneAjoutCompetences([competences]);
          }
          break;

        case 'ajouterPlusieursCompetences':
          genererLigneAjoutCompetences(competences);
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
}

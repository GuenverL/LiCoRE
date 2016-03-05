var competencesValidees;

$(window).on('load', function() {
  'use strict';

  var action = location.search.split('action=')[1];

  if (!action) {
    $('#listeCompetences').empty();
    $('#arbreListeCompetences').hide();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesVisiblesSansFeuilles',
    }).always(function(competences) {
      $('#listeCompetences').append('<a href="#">Liste des compétences</a>');
      $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'afficherCompetences'));
      majArbre('#arbreListeCompetences');
      for (var competence of competences) {
        var competenceObjet = {
          idCompetence: competence.idCompetence,
          nomCompetence: competence.nomCompetence,
          type: 'sousCompetences',
        };
        $('#competence-' + competence.idCompetence).find('a').first().click(competenceObjet, afficherCompetence);
      }
      $('#loader-competences').hide();
      $('#arbreListeCompetences').show();
    });

    $('#listeCompetencesValidees').empty();
    $('#arbreListeCompetencesValidees').hide();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesValides',
    }).always(function(competences) {
      if (competences) {
        competencesValidees = competences;
        $('#arbreListeCompetencesValidees').append('<li id="listeCompetencesValidees"><a href="#">Liste des compétences validées</a>');
        $('#listeCompetencesValidees').append(genererListeCompetences(0, 0, competences, 'afficherCompetences'));
      } else {
        $('#panel-body-competences-validees').append('<p>Aucunes compétences validées</p>');
      }

      majArbre('#arbreListeCompetencesValidees');
      $('#loader-competences-validees').hide();
      $('#arbreListeCompetencesValidees').show();
    });
  } else if (action === 'gestion-competences') {
    $('#arbreGestionCompetences').empty();
    $('#arbreGestionCompetences').hide();
    $.getJSON('api/competences.php', {
      type: 'getToutesLesCompetences',
    }).always(function(competences) {
      if (competences.responseText !== '') {
        $('#arbreGestionCompetences').append('<li id="listeCompetences"><a href="#">Liste des compétences</a>');
        $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'gestionCompetences'));
        majArbre('#arbreGestionCompetences');
        $('[data-toggle="modal"]').tooltip();

        for (var competence of competences) {
          if (((competence.visible !== undefined) && (!competence.visible)) || (competence.feuille && competence.visible)) {
            var visibilite;
            if (competence.feuille && competence.visible) {
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
      }
      $('#loader-competences').hide();
      $('#arbreGestionCompetences').show();
    });
  } else if (action === 'valider-competences-utilisateurs') {
    $('#listeCompetences').empty();
    $('#arbreValidationCompetences').hide();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesValidation',
    }).always(function(competences) {
      $('#listeCompetences').append('<a href="#">Liste des compétences</a>');
      $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'afficherCompetences'));
      majArbre('#arbreValidationCompetences');
      for (var competence of competences) {
        if (competence.feuille) {
          var competenceObjet = {
            idCompetence: competence.idCompetence,
            nomCompetence: competence.nomCompetence,
            type: 'getUtilisateursCompetence',
          };
          $('#competence-' + competence.idCompetence).find('a').first().click(competenceObjet, afficherCompetence);
        }
      }
      $('#loader-competences').hide();
      $('#arbreValidationCompetences').show();
    });
  }
});

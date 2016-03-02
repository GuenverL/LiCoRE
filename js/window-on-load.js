$(window).on('load', function() {
  'use strict';

  var action = location.search.split('action=')[1];

  if (!action) {
    $('#listeCompetences').empty();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesVisiblesSansFeuilles',
    }).always(function(competences) {
      $('#listeCompetences').append('<a href="#">Liste des compétences</a>');
      $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'afficherCompetences'));
      majArbre('#arbreListeCompetences');
    });

    $('#listeCompetencesValidees').empty();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesValides',
    }).always(function(competencesValidees) {
      if (competencesValidees) {
        $('#arbreListeCompetencesValidees').append('<li id="listeCompetencesValidees"><a href="#">Liste des compétences validées</a>');
        $('#listeCompetencesValidees').append(genererListeCompetences(0, 0, competencesValidees, 'afficherCompetences'));
      } else {
        $('#panel-body-competences-validees').append('<p>Aucunes compétences validées</p>');
      }

      majArbre('#arbreListeCompetencesValidees');
    });
  } else if (action === 'gestion-competences') {
    $('#arbreGestionCompetences').empty();
    $.getJSON('api/competences.php', {
      type: 'getToutesLesCompetences',
    }).always(function(competences) {
      if (competences.responseText !== '') {
        $('#arbreGestionCompetences').append('<li id="listeCompetences"><a href="#">Liste des compétences</a>');
        $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'gestionCompetences'));
        majArbre('#arbreGestionCompetences');
        $('[data-toggle="modal"]').tooltip();

        for (var competence of competences) {
          if (competence.visible === 0) {
            var competenceObjet = {
              idCompetence: competence.idCompetence,
              nomCompetence: competence.nomCompetence,
              visibilite: 'setCompetencesVisibles',
            };
            $('#competence-' + competence.idCompetence + '-button-visibilite').off();
            $('#competence-' + competence.idCompetence + '-button-visibilite').click(competenceObjet, setCompetencesVisibiliteOnClick);
          }
        }

      }
    });
  } else if (action === 'valider-competences-utilisateurs') {
    $('#listeCompetences').empty();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesVisibles',
    }).always(function(competences) {
      $('#listeCompetences').append('<a href="#">Liste des compétences</a>');
      $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'afficherCompetences'));
      majArbre('#arbreValidationCompetences');
    });
  }
});

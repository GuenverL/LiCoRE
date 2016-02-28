$(window).on('load', function () {
  'use strict';

  var action = location.search.split('action=')[1];

  if (!action) {
    $('#listeCompetences').empty();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesVisibles',
    }).always(function (competences) {
      $('#listeCompetences').append('<a href="#">Liste des compétences</a>');
      $('#listeCompetences').append(genererListeCompetences(0,0,competences,'afficherCompetences'));
      majArbre('#arbreListeCompetences');
    });

    $('#listeCompetencesValidees').empty();
    $.getJSON('api/competences.php', {
      type: 'getCompetencesValides',
    }).always(function (competencesValidees) {
      if (competencesValidees) {
        $('#arbreListeCompetencesValidees').append('<li id="listeCompetencesValidees"><a href="#">Liste des compétences validées</a>');
        $('#listeCompetencesValidees').append(genererListeCompetences(0,0,competencesValidees,'afficherCompetences'));
      } else {
        $('#panel-body-competences-validees').append('<p>Aucunes compétences validées</p>');
      }

      majArbre('#arbreListeCompetencesValidees');
    });
  } else if (action === 'gestion-competences') {
    $('#arbreGestionCompetences').empty();
    $.getJSON('api/competences.php', {
      type: 'getToutesLesCompetences',
    }).always(function (competences) {
      if (competences.responseText !== '') {
        $('#arbreGestionCompetences').append('<li id="listeCompetences"><a href="#">Liste des compétences</a>');
        $('#listeCompetences').append(genererListeCompetences(0, 0, competences, 'gestionCompetences'));
        majArbre('#arbreGestionCompetences');
        $('[data-toggle="modal"]').tooltip();
      }
    });
  }
});

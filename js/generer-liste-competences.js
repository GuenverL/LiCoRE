function genererListeCompetences(parent, niveau, competencesJson, typeAffichage) {
  'use strict';

  var genererBoutonGestion = function (competence, dataType, title, classGlyphicon) {
    return ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="' + dataType +
      '" data-id-competence="' + competence.idCompetence +
      '" data-nom-competence="' + competence.nomCompetence +
      '" data-placement="top"' +
      ' title="' + title +
      '" class="glyphicon cursor-pointer ' + classGlyphicon +
      '" aria-hidden="true"></span>';
  };

  var html = '';
  var niveauPrecedent = 0;

  if (!niveau && !niveauPrecedent) {
    html += '\n<ul>\n';
  }

  for (var competence of competencesJson) {
    if (parent === competence.idPereCompetence) {
      if (niveauPrecedent < niveau) {
        html += '\n<ul>\n';
      }

      if (typeAffichage === 'gestionCompetences') {
        html += '<li><a href="#">' + competence.nomCompetence + '</a>';

        html += genererBoutonGestion(competence, 'ajouterCompetence', 'Ajouter une compétence', 'glyphicon-plus couleur-verte');
        html += genererBoutonGestion(competence, 'ajouterPlusieursCompetences', 'Ajouter plusieurs compétences', 'glyphicon-th-list couleur-verte');
        html += genererBoutonGestion(competence, 'modifierCompetence', 'Modifier une compétence"', 'glyphicon-pencil couleur-jaune');
        html += genererBoutonGestion(competence, 'supprimerCompetence', 'Supprimer une compétence', 'glyphicon-remove couleur-rouge');
      } else {
        if (competence.valide) {
          html += '<li class="text-validated">';
        } else {
          html += '<li>';
        }

        if (competence.feuille) {
          if (typeAffichage === 'validerCompetencesUtilisateurs') {
            html += '<a onclick="afficherUtilisateursCompetence(this,' + competence.idCompetence +
              ')" href="#">' + competence.nomCompetence + '</a>';
          } else {
            html += '<a onclick="afficherCompetence(this,' + competence.idCompetence +
              ')" href="#">' + competence.nomCompetence + '</a>';
          }
        } else {
          html += '<a href="#">' + competence.nomCompetence + '</a>';
        }
      }

      niveauPrecedent = niveau;
      html += genererListeCompetences(competence.idCompetence, (niveau + 1), competencesJson, typeAffichage);
    }
  }

  if ((niveauPrecedent === niveau) && (niveauPrecedent !== 0)) {
    html += '</ul>\n</li>\n';
  } else if (niveauPrecedent === niveau) {
    html += '</ul>\n';
  } else {
    html += '</li>\n';
  }

  return html;
}

// Mise a jour de l'arbre
function majArbre(arbre) {
  'use strict';
  $(arbre).each(function () {
    $(this).treeview();
  });
}

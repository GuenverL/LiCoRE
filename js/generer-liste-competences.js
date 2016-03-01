function genererBoutonGestion(idCompetence, nomCompetence, dataType, title, classGlyphicon) {
  html = '';

  if (dataType === 'setCompetencesInvisibles' || dataType === 'setCompetencesVisibles') {
    html += ' <span data-toggle="modal" onclick="setCompetencesVisibilite(\'' + dataType + '\',' + idCompetence + ',\'' + nomCompetence + '\')';
  } else {
    html += ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="' + dataType +
      '" data-id-competence="' + idCompetence +
      '" data-nom-competence="' + nomCompetence;
  }

  html += '" data-placement="top"' +
    ' title="' + title +
    '" class="glyphicon cursor-pointer ' + classGlyphicon +
    '" aria-hidden="true"></span>';
  return html;
};

function genererLigneCompetenceGestion(idCompetence, nomCompetence, visible, display) {
  html = '';
  html += '<li id="competence-' + idCompetence + '"';
  if (visible === 0) {
    html += ' class="couleur-grise"';
  }
  if (display === 'display-none') {
    html += ' style="display: none;">';
  } else {
    html += '>';
  }

  html += '<a href="#">' + nomCompetence + '</a>';

  html += genererBoutonGestion(idCompetence, nomCompetence, 'ajouterCompetence', 'Ajouter une compétence', 'glyphicon-plus couleur-verte');
  html += genererBoutonGestion(idCompetence, nomCompetence, 'ajouterPlusieursCompetences', 'Ajouter plusieurs compétences', 'glyphicon-th-list couleur-verte');
  html += genererBoutonGestion(idCompetence, nomCompetence, 'modifierCompetence', 'Modifier une compétence"', 'glyphicon-pencil couleur-jaune');
  if (visible === 1) {
    html += genererBoutonGestion(idCompetence, nomCompetence, 'setCompetencesInvisibles', 'Rendre la compétence invisible', 'glyphicon-eye-close couleur-bleue');
  } else {
    html += genererBoutonGestion(idCompetence, nomCompetence, 'setCompetencesVisibles', 'Rendre la compétence visible', 'glyphicon-eye-open couleur-bleue');
  }

  html += genererBoutonGestion(idCompetence, nomCompetence, 'supprimerCompetence', 'Supprimer une compétence', 'glyphicon-remove couleur-rouge');

  return html;
}

function genererListeCompetences(parent, niveau, competencesJson, typeAffichage) {
  'use strict';

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
        html += genererLigneCompetenceGestion(competence.idCompetence, competence.nomCompetence, competence.visible, 'display-normal');
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
  $(arbre).each(function() {
    $(this).treeview();
  });
}

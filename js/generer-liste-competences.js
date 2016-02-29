function setCompetencesVisibilite(typeVisibilite, idCompetence) {
  'use strict';
  console.log('yolo');
  $.getJSON('api/competences.php', {
    type: 'setCompetencesInvisibles',
    idCompetence: idCompetence,
  }).always(function () {
    console.log('yolo');
  });
}

function genererListeCompetences(parent, niveau, competencesJson, typeAffichage) {
  'use strict';

  var genererBoutonGestion = function (competence, dataType, title, classGlyphicon) {
    html = '';
    if (dataType === 'setCompetencesInvisibles' || dataType === 'setCompetencesVisibles') {
      html += ' <span data-toggle="modal" onclick="setCompetencesVisibilite(' + dataType + ',' + competence.idCompetence + ')';
    } else {
      html += ' <span data-toggle="modal" data-target="#gestionCompetencesModal" data-type="' + dataType +
        '" data-id-competence="' + competence.idCompetence +
        '" data-nom-competence="' + competence.nomCompetence;
    }

    html += '" data-placement="top"' +
      ' title="' + title +
      '" class="glyphicon cursor-pointer ' + classGlyphicon +
      '" aria-hidden="true"></span>';
    return html;
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
        html += '<li id="competence-' + competence.idCompetence + '"';
        if (competence.visible === 0) {
          html += ' class="couleur-grise">';
        } else {
          html += '>';
        }

        html += '<a href="#">' + competence.nomCompetence + '</a>';

        html += genererBoutonGestion(competence, 'ajouterCompetence', 'Ajouter une compétence', 'glyphicon-plus couleur-verte');
        html += genererBoutonGestion(competence, 'ajouterPlusieursCompetences', 'Ajouter plusieurs compétences', 'glyphicon-th-list couleur-verte');
        html += genererBoutonGestion(competence, 'modifierCompetence', 'Modifier une compétence"', 'glyphicon-pencil couleur-jaune');
        if (competence.visible === 1) {
          html += genererBoutonGestion(competence, 'setCompetencesInvisibles', 'Rendre la compétence invisible', 'glyphicon-eye-close couleur-bleue');
        } else {
          html += genererBoutonGestion(competence, 'setCompetencesVisibles', 'Rendre la compétence visible', 'glyphicon-eye-open couleur-bleue');
        }

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
  $(arbre).each(function() {
    $(this).treeview();
  });
}

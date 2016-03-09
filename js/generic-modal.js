$('#genericModal').on('shown.bs.modal', function(event) {
  'use strict';
  var $buttonSubmit = $('#buttonSubmit');

  $(this).removeData('modal');
  $buttonSubmit.off();

  var $button = $(event.relatedTarget);
  var idCompetence = $button[0].dataset.idCompetence;
  var nomCompetence = $button[0].dataset.nomCompetence;
  var type = $button[0].dataset.type;

  var $modal = $(this);

  var updateModal = function(params) {
    $modal.find('.modal-body #genericModalForm').empty();
    $modal.find('.modal-title').text(params.title);
    $modal.find('.modal-body #genericModalForm').append(params.body);
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
      paramsModal.label = 'Nom des nouvelles compétences (séparées par un retour à la ligne) :';
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

    case 'validerCompetence':
      paramsModal.label = 'Explications pour justifier la validation de cette compétence (facultatif mais vivement recommandé) :';
      paramsModal.nomCompetence = nomCompetence;
      paramsModal.title = 'Validation de la compétence "' + nomCompetence + '"';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>' +
        'Attention!' +
        '</strong>' +
        '<p>' +
        'Vous allez valider une compétence et celle ci sera donc mise en attente de validation par un tuteur. Voulez vous continuer ?' +
        '</p>' +
        '</div>' +
        '<div class="form-group">' +
        '<label for="explications-validation" class="control-label" id="label"></label>' +
        '<textarea rows="10" class="form-control" id="explicationsValidation"></textarea>' +
        '</div>';
      break;

    case 'invaliderCompetence':
      paramsModal.label = '';
      paramsModal.nomCompetence = nomCompetence;
      paramsModal.title = 'Invalidation de la compétence "' + nomCompetence + '"';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>' +
        'Attention!' +
        '</strong>' +
        '<p>' +
        'Vous allez invalider une compétence et celle ci sera donc retiré de votre liste de compétences validées. Voulez vous continuer ?' +
        '</p>' +
        '</div>';
      break;

    case 'invaliderCompetenceTemporaire':
      paramsModal.label = '';
      paramsModal.nomCompetence = nomCompetence;
      paramsModal.title = 'Invalidation de la compétence "' + nomCompetence + '"';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>' +
        'Attention!' +
        '</strong>' +
        '<p>' +
        'Vous allez retirer une compétence actuellement en attente de validation par un tuteur. Voulez vous continuer ?' +
        '</p>' +
        '</div>';
      break;

    case 'validationCompetenceParTuteur':
      var nomUtilisateur = $button[0].dataset.nomUtilisateur;
      paramsModal.label = '';
      paramsModal.nomCompetence = '';
      paramsModal.title = 'Valider la compétence "' + nomCompetence + '" pour "' + nomUtilisateur + '"';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>' +
        'Attention!' +
        '</strong>' +
        '<p>' +
        'Vous allez valider cette compétence pour ' + nomUtilisateur + '. Voulez vous continuer ?' +
        '</p>' +
        '</div>';
      break;

    case 'invalidationCompetencesUtilisateurs':
      var nomUtilisateur = $button[0].dataset.nomUtilisateur;
      paramsModal.label = '';
      paramsModal.nomCompetence = '';
      paramsModal.title = 'Invalider la compétence "' + nomCompetence + '" pour "' + nomUtilisateur + '"';
      paramsModal.body = '<div class="alert alert-warning" role="alert">' +
        '<strong>' +
        'Attention!' +
        '</strong>' +
        '<p>' +
        'Vous allez invalider cette compétence pour ' + nomUtilisateur + '. Voulez vous continuer ?' +
        '</p>' +
        '</div>';
      break;
  }

  updateModal(paramsModal);

  var objet = {};
  if ((type === 'validerCompetence') || (type === 'invaliderCompetence') || (type === 'invaliderCompetenceTemporaire')) {
    objet = {
      idCompetence: idCompetence,
      nomCompetence: nomCompetence,
      type: type,
    };
    $buttonSubmit.click(objet, buttonSubmitValidation);
  } else if ((type === 'validationCompetenceParTuteur') || (type === 'invalidationCompetencesUtilisateurs')) {
    objet = {
      idCompetence: idCompetence,
      nomCompetence: nomCompetence,
      idUtilisateur: $button[0].dataset.idUtilisateur,
      type: type,
    };
    $buttonSubmit.click(objet, buttonSubmitValidation);
  } else {
    objet = {
      idCompetence: idCompetence,
      type: type,
    };
    $buttonSubmit.click(objet, buttonSubmitGestionCompetences);
  }
  $buttonSubmit.focus();
});

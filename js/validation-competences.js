function validation(id, nom, button, type){
    span = document.getElementById("idComp" + id)
    switch(type){
        case 'validerCompetence':
            $.getJSON('api/competences.php', {
                type: 'validation',
                idCompetence: id
            });
            button.outerHTML = genererBouttonCompetence(id, nom,"jaune","invaliderCompetence","glyphicon-hourglass");
            break;

        case 'invaliderCompetence':
            $.getJSON('api/competences.php', {
                type: 'invalidation',
                idCompetence: id
            });
            button.outerHTML = genererBouttonCompetence(id, nom,"blanc","validerCompetence","glyphicon-remove");
            break;

        default:
            break;
    }
}

var lienPrecedent = null;

function afficherCompetence(lien, id){

    if (lienPrecedent !== null) {
        lienPrecedent.style.color = 'rgb(34, 68, 238)';
    }
    lienPrecedent = lien;
    lienPrecedent.style.color = 'rgb(232, 85, 36)';

    $.getJSON( 'api/competences.php',{
            type: 'sousCompetences',
            idPere: id,
        },
        function(competences){
            $('#panel-body-competences').empty();
            $('#panel-body-competences').append(
                '<div class="list-group-item heading">' +
                    lien.innerHTML +
                '</div>' +
                '<div id="competences-a-valider" class="list-group">' +
                '</div>');

            for(var competence of competences){
                if(competence.valide == true){
                    if(competence.idTuteur == null){
                        $('#competences-a-valider').append(
                            genererBouttonCompetence(competence.id, competence.nom, "jaune", "invaliderCompetence", "glyphicon-hourglass")
                        );
                    }else{
                        $('#competences-a-valider').append(
                            genererBouttonCompetence(competence.id, competence.nom, "vert", "invaliderCompetence", "glyphicon-ok")
                        );
                    }
                }else{
                    $('#competences-a-valider').append(
                        genererBouttonCompetence(competence.id, competence.nom, "blanc", "validerCompetence", "glyphicon-remove")
                    );
                }
            }
        }
    ).fail(
        function(competences, textStatus, error){
            console.error('getJSON failed, status: ' + textStatus + ', error: ' + error);
        });
}

$('#validationCompetencesModal').on('show.bs.modal', function(event){
    'use strict';
    var $buttonSubmit = $('#buttonSubmit');
    $(this).removeData();
    $buttonSubmit.off();
    var $button = $(event.relatedTarget);
    var idCompetence = $button.data('id-competence');
    var nomCompetence = $button.data('nom-competence');
    var type = $button.data('type');
    var $modal = $(this);

    var updateModal = function(params){
        $modal.find('.modal-body #validationCompetencesModalForm').empty();
        $modal.find('.modal-title').text(params.title);
        $modal.find('.modal-body #validationCompetencesModalForm').append(params.body);
        $modal.find('.modal-body #label').text(params.label);
        $modal.find('.modal-body #nomCompetence').val(params.nomCompetence);
    };

    var paramsModal = {};

    if(type === 'validerCompetence'){
        paramsModal.label = '';
        paramsModal.nomCompetence = nomCompetence;
        paramsModal.title = 'Validation de la compétence "' + nomCompetence + '"';
        paramsModal.body =  '<div class="alert alert-warning" role="alert">' +
                                '<strong>' +
                                    'Attention!' +
                                '</strong>' +
                                '<p>' +
                                    'Vous allez valider une compétence et celle ci sera donc mise en attente de validation par un tuteur. Voulez vous continuer ?' +
                                '</p>' +
                            '</div>';
    }else if(type === 'invaliderCompetence'){
        paramsModal.label = '';
        paramsModal.nomCompetence = nomCompetence;
        paramsModal.title = 'Invalidation de la compétence "' + nomCompetence + '"';
        paramsModal.body =  '<div class="alert alert-warning" role="alert">' +
                                '<strong>' +
                                    'Attention!' +
                                '</strong>' +
                                '<p>' +
                                    'Vous allez invalider une compétence et celle ci sera donc retiré de votre liste de compétences validées. Voulez vous continuer ?' +
                                '</p>' +
                            '</div>';
    }

    updateModal(paramsModal);

    $buttonSubmit.on('click', function(){
        validation(idCompetence, nomCompetence, $button[0], type);
    });
});


function genererBouttonCompetence(id, nom, couleur, type, icon){
    var html='';
    html =  '<div class="list-group-item cursor-pointer couleur-' + couleur + '-bg" data-toggle="modal" data-target="#validationCompetencesModal" data-type="' + type + '" data-id-competence="' + id + '" data-nom-competence="' + nom + '">' +
                '<div class="media">' +
                    '<div class="media-body">' +
                        nom +
                    '</div>' +
                    '<div class="media-right media-middle">' +
                        '<span id="idComp' + id + '" class="glyphicon ' + icon + '" aria-hidden="true">' +
                        '</span>' +
                    '</div>' +
                '</div>' +
            '</div>';
    return html;
}
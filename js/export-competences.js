$('#btnExport').click(function (){
    var arbre = '<?xml version = "1.0" encoding="UTF-8" standalone="yes" ?>\n<arbre>\n';
    for(var i=0, len = competencesValidees.length; i < len; ++i){
        var competence = competencesValidees[i];
        arbre += (  '  <competence>\n' +
                    '       <id>' + competence.idCompetence + '</id>\n' +
                    '       <nom>' + competence.nomCompetence + '</nom>\n' +
                    '       <idPere>' + competence.idPereCompetence + '</idPere>\n');
    }
    arbre += '</arbre>';
    console.log(arbre);
    $('#linkXML').click(function(){
        console.log(arbre);
        this.href = 'data:application/xml;charset=utf-8,' + encodeURIComponent(arbre);
    });
});

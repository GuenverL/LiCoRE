<?php $titre = 'Erreur'; ?>

<?php ob_start(); ?>
<div class="col-md-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading">Erreur</div>
    <div class="panel-body">
      <div class="col-md-12">
        <p>
          <?= $msgErreur ?>
        </p>
      </div>
    </div>
  </div>
</div>

<?php $contenu = ob_get_clean(); ?>

<?php require(DOC_ROOT_PATH . '/views/layout/main.php'); ?>

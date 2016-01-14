<?php

include_once(DOC_ROOT_PATH . '/models/competences.php');

$categories = getCategoriesEtNomsMentions();

// On affiche la vue

include_once(DOC_ROOT_PATH . '/views/index.php');

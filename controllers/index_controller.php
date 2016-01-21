<?php

include_once(DOC_ROOT_PATH . '/models/competences.php');

$competences = getCompetences();

// On affiche la vue

include_once(DOC_ROOT_PATH . '/views/index.php');

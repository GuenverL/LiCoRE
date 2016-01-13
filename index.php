<?php

define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.'Projet_Licore');

include_once(DOC_ROOT_PATH . '/models/connexion_sql.php');

if (!isset($_GET['section']) OR $_GET['section'] == 'index')
{
    include_once(DOC_ROOT_PATH . '/controllers/index_controller.php');
}

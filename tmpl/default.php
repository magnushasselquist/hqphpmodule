<?php

defined('_JEXEC') or die;

// Access to module parameters
$file = $params->get('file', '');
// echo "Fil: " .$file;

ob_start();
include("/var/www/scout/ms-modules/".$file);
// TODO: Relative PATH instead
$page = ob_get_clean();

echo $page;

?>
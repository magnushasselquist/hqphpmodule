<?php

defined('_JEXEC') or die;


// Access to module parameters
$file = $params->get('file', '');
echo "Fil: " .$file;

ob_start();
include("../../ms-modules/".$file);
$page = ob_get_clean();

echo $page;

?>
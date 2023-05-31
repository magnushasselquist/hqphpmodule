<?php

defined('_JEXEC') or die;

echo "TEST";
// Access to module parameters
$file = $params->get('file', '');

ob_start();
include("../../ms-modules/".$file);
$page = ob_get_clean();

echo $page;

?>
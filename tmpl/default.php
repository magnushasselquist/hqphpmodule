<?php

defined('_JEXEC') or die;

// Access to module parameters
$code = $params->get('file', '');

ob_start();
include("../../ms-modules/".$file);
$page = ob_get_clean();

echo $page;

?>
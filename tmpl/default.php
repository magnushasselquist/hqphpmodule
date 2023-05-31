<?php

defined('_JEXEC') or die;

// Access to module parameters
$code = $params->get('file', '');

ob_start();
include($file);
$page = ob_get_clean();

echo $page;

?>
<?php

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx') ?? '');

require ModuleHelper::getLayoutPath('mod_hqphpmodule', $params->get('layout', 'default'));

<?php

/**
 * HQ PHP Module for Joomla.
 *
 * Renders the output of a PHP file picked from the "ms-modules" directory
 * below the site root. Which file to use is chosen per module instance in
 * the module settings.
 *
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

/**
 * Directory that holds the PHP files this module may include, relative to
 * the site root. Must match the "directory" attribute of the "file" field
 * in mod_hqphpmodule.xml.
 */
$baseDir = realpath(JPATH_ROOT . '/ms-modules');

$moduleclass_sfx = htmlspecialchars((string) $params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');

/*
 * Resolve the selected file to an absolute path, but only if it is a plain
 * file name (no directories), ends in .php and really lives inside $baseDir.
 * realpath() also resolves symlinks, so a link pointing outside the
 * directory is rejected too. Anything else leaves $filePath empty and the
 * layout renders nothing for visitors.
 */
$fileName = basename((string) $params->get('file', ''));
$filePath = '';

if ($baseDir !== false && preg_match('/^[\w.-]+\.php$/', $fileName) === 1) {
    $candidate = realpath($baseDir . '/' . $fileName);

    if (
        $candidate !== false
        && is_file($candidate)
        && strpos($candidate, $baseDir . DIRECTORY_SEPARATOR) === 0
    ) {
        $filePath = $candidate;
    }
}

require ModuleHelper::getLayoutPath('mod_hqphpmodule', $params->get('layout', 'default'));

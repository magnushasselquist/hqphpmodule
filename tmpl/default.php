<?php

/**
 * Default layout for HQ PHP Module.
 *
 * Variables available from mod_hqphpmodule.php:
 *
 * @var string $filePath        Absolute, validated path to the PHP file to render, or '' if none.
 * @var string $moduleclass_sfx Escaped module class suffix.
 * @var object $module          The module record (title etc.).
 *
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

if ($filePath === '') {
    // Visitors get no output. Users who may edit modules get a hint so a
    // missing or misconfigured file does not fail silently.
    $user = Factory::getApplication()->getIdentity();

    if ($user !== null && $user->authorise('core.edit', 'com_modules')) {
        echo '<div class="alert alert-warning">HQPHPMODULE: no valid PHP file selected for module "'
            . htmlspecialchars((string) $module->title, ENT_QUOTES, 'UTF-8')
            . '". Pick a .php file from the ms-modules directory in the module settings.</div>';
    }

    return;
}

ob_start();

try {
    include $filePath;
} finally {
    // Make sure the output buffer is closed even if the included file throws.
    $page = ob_get_clean();
}

echo $page;

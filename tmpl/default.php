<?php

/**
 * Default layout for HQ PHP Module.
 *
 * Variables provided by the dispatcher:
 *
 * @var string                                   $filePath  Absolute, validated path to the PHP file to render, or '' if none.
 * @var bool                                     $canEdit   Whether the current user may edit modules.
 * @var \stdClass                                $module    The module record (title etc.).
 * @var \Joomla\CMS\Application\CMSApplication   $app       The application.
 * @var \Joomla\Input\Input                      $input     The request input.
 * @var \Joomla\Registry\Registry                $params    The module parameters.
 * @var string                                   $template  The active template name.
 *
 * The included file sees the same variables.
 *
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

if ($filePath === '') {
    // Visitors get no output. Users who may edit modules get a hint so a
    // missing or misconfigured file does not fail silently.
    if ($canEdit) {
        echo '<div class="alert alert-warning">'
            . Text::sprintf('MOD_HQPHPMODULE_NO_FILE', htmlspecialchars((string) $module->title, ENT_QUOTES, 'UTF-8'))
            . '</div>';
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

<?php

/**
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Hq\Module\Hqphpmodule\Site\Helper;

use Joomla\Registry\Registry;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Helper for HQ PHP Module.
 */
final class HqphpmoduleHelper
{
    /**
     * Directory below the site root that holds the PHP files this module may
     * include. Must match the "directory" attribute of the "file" field in
     * mod_hqphpmodule.xml.
     */
    public const DIRECTORY = 'ms-modules';

    /**
     * Resolves the "file" parameter to an absolute path.
     *
     * Only a plain file name (no directory part) ending in .php that really
     * lives directly inside the allowed directory is accepted. realpath()
     * resolves symlinks, so a link pointing outside the directory is rejected
     * as well. Anything else yields ''.
     *
     * @param   Registry  $params  The module parameters.
     *
     * @return  string  Absolute path to the file, or '' if none is valid.
     */
    public function resolveFile(Registry $params): string
    {
        return $this->resolveFileName((string) $params->get('file', ''), JPATH_ROOT . '/' . self::DIRECTORY);
    }

    /**
     * Validates a file name against a base directory.
     *
     * Kept separate from resolveFile() so the rule can be tested without a
     * Registry or a Joomla constant.
     *
     * @param   string  $fileName  The configured file name.
     * @param   string  $baseDir   The directory the file must live in.
     *
     * @return  string  Absolute path to the file, or '' if it is not acceptable.
     */
    public function resolveFileName(string $fileName, string $baseDir): string
    {
        $realBase = realpath($baseDir);
        $fileName = basename($fileName);

        if ($realBase === false || preg_match('/^[\w.-]+\.php$/', $fileName) !== 1) {
            return '';
        }

        $candidate = realpath($realBase . '/' . $fileName);

        if (
            $candidate === false
            || !is_file($candidate)
            || strpos($candidate, $realBase . DIRECTORY_SEPARATOR) !== 0
        ) {
            return '';
        }

        return $candidate;
    }
}

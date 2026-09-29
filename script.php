<?php

/**
 * Installer script for HQ PHP Module.
 *
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScript;

/**
 * Checks minimum versions before install and removes files from pre-1.1
 * releases after an update.
 */
class Mod_HqphpmoduleInstallerScript extends InstallerScript
{
    /**
     * Minimum PHP version. Checked by InstallerScript::preflight().
     *
     * @var  string
     */
    protected $minimumPhp = '8.1.0';

    /**
     * Minimum Joomla version. Checked by InstallerScript::preflight().
     *
     * @var  string
     */
    protected $minimumJoomla = '4.0.0';

    /**
     * Files from earlier releases that the namespaced module no longer uses.
     * Paths are relative to the site root.
     *
     * @var  string[]
     */
    protected $deleteFiles = [
        '/modules/mod_hqphpmodule/mod_hqphpmodule.php',
    ];

    /**
     * Runs after install, update or discover_install.
     *
     * @param   string            $type    The action: install, update or discover_install.
     * @param   InstallerAdapter  $parent  The installer adapter.
     *
     * @return  bool
     */
    public function postflight($type, $parent)
    {
        if ($type === 'update') {
            $this->removeFiles();
        }

        return true;
    }
}

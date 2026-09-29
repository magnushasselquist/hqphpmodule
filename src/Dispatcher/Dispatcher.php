<?php

/**
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Hq\Module\Hqphpmodule\Site\Dispatcher;

use Hq\Module\Hqphpmodule\Site\Helper\HqphpmoduleHelper;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Dispatcher for HQ PHP Module.
 *
 * Resolves the configured PHP file to a validated absolute path and hands it
 * to the layout together with Joomla's standard layout variables
 * ($module, $app, $input, $params, $template).
 */
final class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array
     */
    protected function getLayoutData(): array
    {
        $data = parent::getLayoutData();

        /** @var HqphpmoduleHelper $helper */
        $helper = $this->getHelperFactory()->getHelper('HqphpmoduleHelper');

        // '' when nothing valid is selected; the layout then renders nothing for visitors.
        $data['filePath'] = $helper->resolveFile($data['params']);

        // Whether the current user may edit modules. Used to show a hint instead of silent output.
        $user            = $this->getApplication()->getIdentity();
        $data['canEdit'] = $user !== null && $user->authorise('core.edit', 'com_modules');

        return $data;
    }
}

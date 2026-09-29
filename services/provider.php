<?php

/**
 * Service provider for HQ PHP Module.
 *
 * Joomla boots the module through this file and asks the container for the
 * module's dispatcher and helper factory.
 *
 * @copyright  Copyright 2023 Magnus Hasselquist
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the module's services with the DI container.
     */
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new ModuleDispatcherFactory('\\Hq\\Module\\Hqphpmodule'));
        $container->registerServiceProvider(new HelperFactory('\\Hq\\Module\\Hqphpmodule\\Site\\Helper'));
        $container->registerServiceProvider(new Module());
    }
};

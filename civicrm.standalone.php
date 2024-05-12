<?php

/**
 * Stub file for CiviCRM Standalone
 *
 * It provides a common codepath for index.php / cv / any other entrypoint to
 * locate and run the CiviCRM autoloader, classloader and settingsloader
 */

// this file should always be in the project root
$appRootPath = __DIR__;

# // standard "flat earth" file structure
# $autoLoader = implode(DIRECTORY_SEPARATOR, [$appRootPath, 'core', 'vendor', 'autoload.php']);
# $classLoader = implode(DIRECTORY_SEPARATOR, [$appRootPath, 'core', 'CRM', 'Core', 'ClassLoader.php']);

// alternative composer-style file structure:
$autoLoader = implode(DIRECTORY_SEPARATOR, [$appRootPath , 'vendor', 'autoload.php']);
$classLoader = implode(DIRECTORY_SEPARATOR, [$appRootPath, 'vendor', 'civicrm', 'civicrm-core', 'CRM', 'Core', 'ClassLoader.php']);

// find files in the settings subdirectory
// note: glob returns files in alphabetical order
$settingsPaths = [
  ...glob(implode(DIRECTORY_SEPARATOR, [$appRootPath, 'settings', '*.settings.php'])),
];

# // alternative single settings file
# $settingsPaths = [implode(DIRECTORY_SEPARATOR, [__DIR__, 'civicrm.settings.php'])];

require_once $autoLoader;
require_once $classLoader;
\CRM_Core_ClassLoader::singleton()->register();

\Civi\Standalone\AppSettings::initialise(
  $appRootPath,
)->load(
  $settingsPaths
)->export();

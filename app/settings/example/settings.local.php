<?php

/**
 * @file
 * Local settings.
 */

use Drupal\Component\Assertion\Handle;

assert_options(ASSERT_ACTIVE, TRUE);
Handle::register();

//$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
// Optional monolog services.
$settings['container_yamls'][] = __DIR__ . '/services.monolog.yml';
$settings['container_yamls'][] = __DIR__ . '/services.local.yml';

if (file_exists(__DIR__ . '/settings.cache.php')) {
  include_once __DIR__ . '/settings.cache.php';
}

if (file_exists(__DIR__ . '/settings.proxy.php')) {
  include_once __DIR__ . '/settings.proxy.php';
}

if (file_exists(__DIR__ . '/settings.solr.php')) {
  include_once __DIR__ . '/settings.solr.php';
}

if (file_exists(__DIR__ . '/settings.elastic.php')) {
  include_once __DIR__ . '/settings.elastic.php';
}

if (file_exists(__DIR__ . '/settings.trusted-hosts.php')) {
  include_once __DIR__ . '/settings.trusted-hosts.php';
}

if (file_exists(__DIR__ . '/settings.email.php')) {
  include_once __DIR__ . '/settings.email.php';
}

$config['system.logging']['error_level'] = 'verbose';

//$settings['extension_discovery_scan_tests'] = TRUE;
//$settings['rebuild_access'] = TRUE;
//$settings['skip_permissions_hardening'] = TRUE;
$settings['config_exclude_modules'] = [
  'automated_cron',
  'composer_deploy',
  'devel',
  'devel_php',
  'devel_entity_updates',
  'unused_modules',
  'upgrade_status',
];

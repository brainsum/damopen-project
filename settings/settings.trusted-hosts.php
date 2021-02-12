<?php

/**
 * @file
 * Trusted hosts.
 */

$settings['trusted_host_patterns'] = [
  '^' . str_replace('.', '\.', getenv('DRUPAL_BASE_URL')) . '$',
];

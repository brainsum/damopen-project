<?php

/**
 * @file
 * Proxy settings.
 */

use Symfony\Component\HttpFoundation\Request;

if (!empty(getenv('DRUPAL_PROXY_IP'))) {
  $settings['reverse_proxy'] = TRUE;
  $settings['reverse_proxy_addresses'] = [
    getenv('DRUPAL_PROXY_IP')
  ];
  // See https://symfony.com/doc/current/deployment/proxies.html.
  $settings['reverse_proxy_trusted_headers'] = Request::HEADER_X_FORWARDED_ALL | Request::HEADER_FORWARDED;
}

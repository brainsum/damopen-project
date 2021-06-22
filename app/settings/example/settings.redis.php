<?php

/**
 * @file
 * Configs for the redis module.
 */

$redisEnable = getenv('REDIS_ENABLE');

if (empty($redisEnable) || (bool) $redisEnable === FALSE) {
  return;
}

if (file_exists(__DIR__ . '/services.redis.yml')) {
  $settings['container_yamls'][] = __DIR__ . '/services.redis.yml';
}

$settings['redis.connection']['host'] = getenv('REDIS_HOST');
if (!empty(getenv('REDIS_PASSWORD'))) {
  $settings['redis.connection']['password'] = getenv('REDIS_PASSWORD');
}

$settings['redis.connection']['interface'] = 'PhpRedis';

$settings['cache']['default'] = 'cache.backend.redis';
// Added by core.
//$settings['cache']['bins']['static'] = 'cache.backend.redis';
$settings['cache']['bins']['bootstrap'] = 'cache.backend.chainedfast';
$settings['cache']['bins']['config'] = 'cache.backend.chainedfast';
//$settings['cache']['bins']['default'] = 'cache.backend.redis';
//$settings['cache']['bins']['entity'] = 'cache.backend.redis';
$settings['cache']['bins']['menu'] = 'cache.backend.chainedfast';
//$settings['cache']['bins']['render'] = 'cache.backend.redis';
//$settings['cache']['bins']['data'] = 'cache.backend.redis';
$settings['cache']['bins']['discovery'] = 'cache.backend.chainedfast';
// Added by the dynamic_page_cache module.
//$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.redis';
// Added by the jsonapi module.
$settings['cache']['bins']['jsonapi_resource_types'] = 'cache.backend.chainedfast';
// Added by the migrate module.
$settings['cache']['bins']['migrate'] = 'cache.backend.chainedfast';
$settings['cache']['bins']['discovery_migration'] = 'cache.backend.chainedfast';
// Added by the page_cache module.
//$settings['cache']['bins']['page'] = 'cache.backend.redis';
// Added by the rest module.
$settings['cache']['bins']['rest'] = 'cache.backend.chainedfast';
// Added by the toolbar module.
$settings['cache']['bins']['toolbar'] = 'cache.backend.chainedfast';
// Added by the geocoder module.
//$settings['cache']['bins']['geocoder'] = 'cache.backend.chainedfast';
$settings['queue_default'] = 'queue.redis_reliable';

$settings['redis_compress_length'] = 100;
$settings['redis_compress_level'] = 1;

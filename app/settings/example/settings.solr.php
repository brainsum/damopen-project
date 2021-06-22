<?php

$config['search_api.server.solr_server']['backend_config']['connector_config']['host'] = getenv('SOLR_HOST');
$config['search_api.server.solr_server']['backend_config']['connector_config']['core'] = getenv('SOLR_CORE');

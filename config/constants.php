<?php
if (!defined('SWAGGER_API_HOST_LOCAL'))
define('SWAGGER_API_HOST_LOCAL',env('SWAGGER_API_HOST_LOCAL', 'http://localhost:8000'));
if (!defined('SWAGGER_API_HOST_DEV'))
define('SWAGGER_API_HOST_DEV',env('SWAGGER_API_HOST_DEV', 'https://dev.api.focus.grupomobius.com'));
if (!defined('SWAGGER_API_HOST_PROD'))
define('SWAGGER_API_HOST_PROD',env('SWAGGER_API_HOST_PROD', 'https://api.focus.grupomobius.com'));

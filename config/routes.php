<?php
use Cake\Routing\Router;

Router::plugin('DatabaseLogger', function ($routes) {
    $routes->fallbacks('DashedRoute');
});

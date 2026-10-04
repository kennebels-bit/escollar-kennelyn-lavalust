<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

if (!function_exists('handle_cors')) {
    function handle_cors()
    {
        header('Content-Type: application/json; charset=utf-8');

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        $configured_origin = rtrim((string) config_item('allow_origin'), '/');
        $allowed = $configured_origin === '*'
            || ($origin !== '' && hash_equals($configured_origin, rtrim($origin, '/')));

        header('Vary: Origin');

        if ($allowed && $origin !== '') {
            header('Access-Control-Allow-Origin: ' . ($configured_origin === '*' ? '*' : $origin));
        }

        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
            header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Authorization, Content-Type');
            header('Access-Control-Max-Age: 86400');
            http_response_code(204);
            exit;
        }
    }
}
